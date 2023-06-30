<?php

namespace Dmn\Txtbox\Examples;

use Illuminate\Notifications\Notification;
use Dmn\Txtbox\Channels\Txtbox;
use Dmn\Txtbox\Messages\TxtboxMessage;

class SmsNotification extends Notification
{
    /**
     * Get the notification channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return [Txtbox::class];
    }

    /**
     * Get Txtbox message
     *
     * @param mixed $notifiable
     *
     * @return TxtboxMessage
     */
    public function toTxtbox($notifiable): TxtboxMessage
    {
        return (new TxtboxMessage())
            ->setMobileNumber($notifiable['mobile_number'])
            ->setMessage('This is a sample sms from package channel txtbox');
    }
}
