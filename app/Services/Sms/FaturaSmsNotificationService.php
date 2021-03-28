<?php

namespace App\Services\Sms;

use App\Models\Abone;
use App\Models\Fatura;
use App\Models\Mukellef;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

class FaturaSmsNotificationService
{
    public const FATURA_CREATED_MESSAGE = 'Sayın %s, %s numaralı aboneliğiniz için'
        . ' %s son ödeme tarihli %s TL tutarındaki %s faturanız hazırdır.'
        . ' Ödeme yaptıysanız bu bildirimi dikkate almayınız.';

    /**
     * @var SmsService
     */
    protected $smsService;

    /**
     * FaturaSmsNotificationService constructor.
     *
     * @param SmsService $smsService
     */
    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * @param Fatura $fatura
     *
     * @return bool
     *
     * @throws GuzzleException
     * @throws Exception
     */
    public function send(Fatura $fatura): bool
    {
        $message = sprintf(
            self::FATURA_CREATED_MESSAGE,
            $fatura->abone->mukellef->{Mukellef::COLUMN_UNVAN},
            $fatura->abone->{Abone::COLUMN_ABONE_NO},
            $fatura->{Fatura::COLUMN_SON_ODEME_TARIHI}->format(config('common.date.format')),
            $fatura->{Fatura::COLUMN_TOPLAM_ODENECEK_UCRET},
            $fatura->{Fatura::COLUMN_TUR}
        );

        $phone = $fatura->abone->mukellef->{Mukellef::COLUMN_TELEFON};

        if (10 > strlen($phone)) {
            return true;
        }

        return $this->smsService->sendMessageToPhone($phone, $message);
    }
}
