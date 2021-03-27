<?php


namespace App\Services\Sms;


use App\Helpers\Utils;
use App\Services\Sms\Contracts\SmsGatewayContract;
use Exception;
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
        $phone = Utils::getNormalizedTelephoneNumber($phone);

        return $this->smsService
            ->sendMessageToPhone($phone, $message);
    }
}
