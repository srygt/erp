<?php


namespace App\Services\Sms;


use App\Services\Sms\Contracts\SmsGatewayContract;
use GuzzleHttp\Exception\GuzzleException;

class SmsService
{
    /** @var SmsGatewayContract $smsService */
    protected $smsService;

    /**
     * SmsService constructor.
     *
     * @param SmsGatewayContract $smsService
     */
    public function __construct(SmsGatewayContract $smsService) {
        $this->smsService = $smsService;
    }

    /**
     * @param string $phone
     * @param string $message
     *
     * @return bool
     *
     * @throws GuzzleException
     * @throws Exception
     */
    public function sendMessageToPhone(string $phone, string $message): bool
    {
        return $this->smsService
            ->sendMessageToPhone($phone, $message);
    }
}
