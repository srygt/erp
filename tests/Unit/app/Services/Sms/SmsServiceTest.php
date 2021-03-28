<?php

namespace Tests\Unit\app\Services\Sms;

use App\Services\Sms\Contracts\SmsGatewayContract;
use App\Services\Sms\SmsService;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;

class SmsServiceTest extends TestCase
{
    /**
     * @throws GuzzleException
     */
    public function testSendMessageToPhoneSuccessfulOperation()
    {
        $fakePhoneArgument = '5000000000';
        $fakeMessageArgument = 'Lorem ipsum';

        $mockedSmsGateway = \Mockery::mock(SmsGatewayContract::class);
        $mockedSmsGateway->shouldReceive('sendMessageToPhone')
            ->once()
            ->with(
                '90' . $fakePhoneArgument,
                $fakeMessageArgument
            )
            ->andReturn(true);

        /** @var SmsService $service */
        $service = app(
            SmsService::class,
            [
                'smsGateway' => $mockedSmsGateway
            ]
        );

        $response = $service->sendMessageToPhone(
            $fakePhoneArgument,
            $fakeMessageArgument
        );

        $this->assertTrue($response);
    }

    /**
     * @throws GuzzleException
     */
    public function testSendMessageToPhoneShouldThrowExceptionSinceWrongPhoneNumber()
    {
        $fakePhoneArgument = '500000000'; // 1 Digit is missing!
        $fakeMessageArgument = 'Lorem ipsum';

        $mockedSmsGateway = \Mockery::mock(SmsGatewayContract::class);

        /** @var SmsService $service */
        $service = app(
            SmsService::class,
            [
                'smsGateway' => $mockedSmsGateway
            ]
        );

        $this->expectException(Exception::class);

        $service->sendMessageToPhone(
            $fakePhoneArgument,
            $fakeMessageArgument
        );
    }
}
