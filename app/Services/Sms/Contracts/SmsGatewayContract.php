<?php


namespace App\Services\Sms\Contracts;


use Exception;
use GuzzleHttp\Exception\GuzzleException;

interface SmsGatewayContract
{
    /**
     * It returns the secret data which must be hidden
     * in log files (api username, api password etc.)
     *
     * @return array
     */
    public static function getFieldsToCensor(): array;

    /**
     * @param string $phone
     * @param string $message
     *
     * @return bool
     *
     * @throws GuzzleException
     * @throws Exception
     */
    public function sendMessageToPhone(string $phone, string $message): bool;
}
