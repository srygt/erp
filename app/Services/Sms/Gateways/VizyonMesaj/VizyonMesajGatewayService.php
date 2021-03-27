<?php

namespace App\Services\Sms\Gateways\VizyonMesaj;

use App\Services\Sms\Contracts\SmsGatewayContract;
use App\Services\Sms\Logger;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class VizyonMesajGatewayService implements SmsGatewayContract
{
    protected const URL = 'http://vizyonmesaj.net';

    /** @var string $logFileName */
    protected $logFileName;

    /**
     * @inheritDoc
     */
    public static function getFieldsToCensor(): array
    {
        return [
            config('sms.vizyonmesaj.username'),
            config('sms.vizyonmesaj.password'),
            config('sms.vizyonmesaj.origin'),
        ];
    }

    /**
     * @inheritDoc
     *
     * @throws GuzzleException
     * @throws Exception
     */
    public function sendMessageToPhone(string $phone, string $message): bool {
        $postBody = '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"'
            . ' xmlns:xsd="http://www.w3.org/2001/XMLSchema"'
            . ' xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Header>
    <securty xmlns="http://tempuri.org/">
      <KullaniciAdi>' . config('sms.vizyonmesaj.username') . '</KullaniciAdi>
      <Parola>' . config('sms.vizyonmesaj.password') . '</Parola>
      <Orijin>' . config('sms.vizyonmesaj.origin') . '</Orijin>
    </securty>
  </soap:Header>
  <soap:Body>
    <CokMesajCokNumara xmlns="http://tempuri.org/">
      <MessageWithNumber>
        <MesajVeTelefonNo>
          <Mesaj>' . $message . '</Mesaj>
          <TeleNo>' . $phone . '</TeleNo>
        </MesajVeTelefonNo>
      </MessageWithNumber>
    </CokMesajCokNumara>
  </soap:Body>
</soap:Envelope>';

        $response = $this->request(
            '/services/vizyonmesaj.asmx',
            $postBody
        );

        if (stripos($response->getBody()->getContents(), 'hata')) {
            throw new Exception('SMS Gönderiminde Hata! (' . $this->logFileName . ')');
        }

        return true;
    }

    /**
     * @param $path
     * @param $postBody
     *
     * @return ResponseInterface
     *
     * @throws GuzzleException
     */
    protected function request($path, $postBody): ResponseInterface
    {
        $handler = HandlerStack::create();

        $this->logFileName = date('H-i-s') . '.log';

        $logFileName = $this->logFileName;
        $fieldsToCensor = self::getFieldsToCensor();

        $handler->push(Middleware::mapRequest(
            function (RequestInterface $request) use ($logFileName, $fieldsToCensor) {
                Logger::log(
                    $logFileName,
                    $fieldsToCensor,
                    $request
                );

                return $request;
            }
        ));

        $handler->push(Middleware::mapResponse(
            function (ResponseInterface $response) use ($logFileName, $fieldsToCensor) {
                Logger::log(
                    $logFileName,
                    $fieldsToCensor,
                    $response
                );

                $response->getBody()->rewind();
                return $response;
            }
        ));

        $client = new Client([
            'base_uri' => self::URL,
            'timeout' => 30.0,
            'handler' => $handler,
        ]);

        return $client->request(
            'POST',
            $path,
            [
                'headers' => [
                    'Content-Type' => 'text/xml; charset=utf-8',
                    'ACCEPT' => 'application/json',
                ],
                'body' => $postBody,
            ]
        );
    }
}
