<?php

namespace App\Listeners;

use App\Events\FaturaCreated;
use App\Services\Sms\FaturaSmsNotificationService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendFaturaSmsNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var FaturaSmsNotificationService
     */
    protected $notificationService;

    /**
     * Create the event listener.
     *
     * @param FaturaSmsNotificationService $service
     */
    public function __construct(FaturaSmsNotificationService $service)
    {
        $this->notificationService = $service;
    }

    /**
     * Handle the event.
     *
     * @param FaturaCreated $event
     * @return void
     * @throws GuzzleException
     */
    public function handle(FaturaCreated $event)
    {
        $this->notificationService->send($event->getFatura());
    }
}
