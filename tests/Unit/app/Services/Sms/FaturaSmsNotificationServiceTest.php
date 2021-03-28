<?php

namespace Tests\Unit\app\Services\Sms;

use App\Models\Fatura;
use App\Services\Sms\FaturaSmsNotificationService;
use App\Services\Sms\SmsService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class FaturaSmsNotificationServiceTest extends TestCase
{
    /**
     * @throws GuzzleException
     */
    public function testSendSuccessfulOperation()
    {
        $phone = '5000000000';
        $unvan = 'Test A. Ş.';
        $aboneNo = '007';
        $sonOdemeTarihi = '31.12.2021';
        $toplamUcret = '20.07';
        $aboneTur = 'elektrik';

        /** @var Fatura $mockedFaturaModel */
        $mockedFaturaModel = $this->mockModel(
            Fatura::class,
            [
                'abone' => [
                    'mukellef' => [
                        'unvan' => $unvan,
                        'telefon' => $phone,
                    ],
                    'abone_no' => $aboneNo,
                ],
                'son_odeme_tarihi' => Carbon::createFromDate($sonOdemeTarihi),
                'toplam_odenecek_ucret' => $toplamUcret,
                'tur' => $aboneTur,
            ]
        );

        $message = "Sayın ${unvan}, ${aboneNo} numaralı aboneliğiniz için"
            . " ${sonOdemeTarihi} son ödeme tarihli ${toplamUcret} TL tutarındaki ${aboneTur} faturanız hazırdır."
            . " Ödeme yaptıysanız bu bildirimi dikkate almayınız.";

        $mockedSmsService = \Mockery::mock(SmsService::class);
        $mockedSmsService->shouldReceive('sendMessageToPhone')
            ->once()
            ->with(
                $phone,
                $message
            )
            ->andReturn(true);

        /** @var FaturaSmsNotificationService $service */
        $service = app(
            FaturaSmsNotificationService::class,
            ['smsService' => $mockedSmsService]
        );

        $response = $service->send($mockedFaturaModel);

        $this->assertTrue($response);
    }

    /**
     * @throws GuzzleException
     */
    public function testSendShouldNotSendSmsSinceWrongPhoneNumber()
    {
        $phone = '500000000'; // 1 Digit is missing!
        $unvan = 'Test A. Ş.';
        $aboneNo = '007';
        $sonOdemeTarihi = '31.12.2021';
        $toplamUcret = '20.07';
        $aboneTur = 'elektrik';

        /** @var Fatura $mockedFaturaModel */
        $mockedFaturaModel = $this->mockModel(
            Fatura::class,
            [
                'abone' => [
                    'mukellef' => [
                        'unvan' => $unvan,
                        'telefon' => $phone,
                    ],
                    'abone_no' => $aboneNo,
                ],
                'son_odeme_tarihi' => Carbon::createFromDate($sonOdemeTarihi),
                'toplam_odenecek_ucret' => $toplamUcret,
                'tur' => $aboneTur,
            ]
        );

        $mockedSmsService = \Mockery::mock(SmsService::class);
        $mockedSmsService->shouldNotReceive('sendMessageToPhone');

        /** @var FaturaSmsNotificationService $service */
        $service = app(
            FaturaSmsNotificationService::class,
            ['smsService' => $mockedSmsService]
        );

        $response = $service->send($mockedFaturaModel);

        $this->assertTrue($response);
    }
}
