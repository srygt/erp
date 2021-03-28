<?php


namespace App\Services\Sms;


use App\Helpers\Utils;
use App\Services\Sms\Contracts\SmsGatewayContract;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

class SmsService
{
    /** @var SmsGatewayContract $smsGateway */
    protected $smsGateway;

    /**
     * SmsService constructor.
     *
     * @param SmsGatewayContract $smsGateway
     */
    public function __construct(SmsGatewayContract $smsGateway) {
        $this->smsGateway = $smsGateway;
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
        $phone = Utils::getNormalizedTelephoneNumber($phone);

        return $this->smsGateway
            ->sendMessageToPhone($phone, $message);
    }
}
