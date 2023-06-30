<?php

namespace Dmn\Txtbox\Channels;

use Illuminate\Notifications\Notification;
use Dmn\Txtbox\Txtbox as TxtboxTxtbox;

class Txtbox
{
    protected $client;

    /**
     * Construct
     *
     * @param TxtboxTxtbox $client
     */
    public function __construct(TxtboxTxtbox $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     */
    public function send($notifiable, Notification $notification)
    {
        $smsMessage = $notification->toTxtbox($notifiable);

        $this->client->send(
            $smsMessage->getMobileNumber(),
            $smsMessage->getMessage()
        );
    }
}
