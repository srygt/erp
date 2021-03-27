<?php

namespace App\Services\Sms;

use Illuminate\Support\Facades\Storage;
use Psr\Http\Message\MessageInterface;

class Logger
{
    /**
     * Logger constructor.
     */
    private function __construct()
    {

    }

    /**
     * @param string $fileName
     * @param array $fieldsToCensor
     * @param MessageInterface $message
     *
     * @return bool
     */
    public static function log(string $fileName, array $fieldsToCensor, $message): bool {
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
