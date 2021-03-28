<?php

namespace Tests\Unit\app\Providers;

use App\Events\FaturaCreated;
use App\Listeners\SendFaturaSmsNotification;
use App\Models\Fatura;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class EventServiceProviderTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testSendFaturaSmsNotificationShouldBeListenFaturaCreatedEvent()
    {
        $mockedService = \Mockery::mock(SendFaturaSmsNotification::class);
        $mockedService
            ->shouldReceive('setJob')
            ->once();
        $mockedService
            ->shouldReceive('handle')
            ->once();

        $this->app->bind(SendFaturaSmsNotification::class, function() use (&$mockedService) {
            return $mockedService;
        });

        $fakeFatura = Fatura::first();
        FaturaCreated::dispatch($fakeFatura);
    }
}
