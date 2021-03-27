<?php

namespace App\Services\Sms\Middleware;

use Closure;
use Illuminate\Support\Facades\Storage;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GuzzleHttpLoggerMiddleware
{
    /**
     * @var string
     */
    protected $fileName;

    /**
     * @var array
     */
    protected $fieldsToCensor;

    /**
     * GuzzleHttpLoggerMiddleware constructor.
     *
     * @param string $fileName
     * @param array $fieldsToCensor
     */
    public function __construct(string $fileName, array $fieldsToCensor)
    {
        $this->fileName = $fileName;
        $this->fieldsToCensor = $fieldsToCensor;
    }

    /**
     * @return Closure
     */
    public function getHandler(): Closure
    {
        $fileName = $this->fileName;
        $fieldsToCensor = $this->fieldsToCensor;

        return function (callable $handler) use ($fileName, $fieldsToCensor) {
            return function (
                RequestInterface $request,
                array $options
            ) use ($handler, $fileName, $fieldsToCensor) {

                self::log($fileName, $fieldsToCensor, $request);

                $promise = $handler($request, $options);

                return $promise->then(
                    function (ResponseInterface $response) use ($fileName, $fieldsToCensor) {

                        self::log($fileName, $fieldsToCensor, $response);

                        return $response;
                    }
                );
            };
        };
    }

    /**
     * @param string $fileName
     * @param array $fieldsToCensor
     * @param MessageInterface $message
     *
     * @return bool
     */
    protected static function log(string $fileName, array $fieldsToCensor, MessageInterface $message): bool {
        $header = $message->getHeaders();
        $header = self::getRawHeader($header);

        $body = $message->getBody()->getContents();

        $logText = $header . PHP_EOL . PHP_EOL . $body;
        $logText = self::censorSecrets($fieldsToCensor, $logText);

        $logPath = self::getLogPath($fileName);
        $logContentSeparator = PHP_EOL . PHP_EOL . PHP_EOL;

        return Storage::append($logPath, $logText, $logContentSeparator);
    }

    /**
     * @param string $fileName
     *
     * @return string
     */
    protected static function getLogPath(string $fileName): string {
        $year = date('Y');
        $month = date('m');
        $day = date('d');

        return config('sms.log.path')
            . $year . DIRECTORY_SEPARATOR
            . $month . DIRECTORY_SEPARATOR
            . $day . DIRECTORY_SEPARATOR
            . $fileName;
    }

    /**
     * @param array $fieldsToCensor
     * @param string $text
     *
     * @return string
     */
    protected static function censorSecrets(array $fieldsToCensor, string $text): string {
        $replace = array_fill(0, count($fieldsToCensor), '***');

        return str_replace($fieldsToCensor, $replace, $text);
    }

    /**
     * @param array $headers
     *
     * @return string
     */
    protected static function getRawHeader(array $headers): string {
        $rawHeader = '';

        array_walk(
            $headers,
            function ($value, $key) use (&$rawHeader) {
                $value = implode(' +++ ', $value);
                $rawHeader .= $key . ': ' . $value . PHP_EOL;
            }
        );

        return rtrim($rawHeader);
    }
}
