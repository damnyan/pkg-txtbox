# pano?

## install
`composer require dmn/pkg-txtbox`

## configuration
`txtbox.php`

```php
<?php

return [
    'base_uri' => env('TXTBOX_BASE_URI', 'https://ws-live.txtbox.com/'),
    'api_key' => env('TXTBOX_API_KEY'),
    'guzzle' => [],
];
```

## service provider
`Dmn\Txtbox\ServiceProvider::class`

## example
```php
<?php

namespace Dmn\Txtbox\Examples;

use Dmn\Txtbox\Channels\Txtbox;
use Dmn\Txtbox\Messages\TxtboxMessage;
use Illuminate\Notifications\Notification;

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
```

## NOTE:
#### pwede gamitin rekta yung `Dmn\Txtbox\Txtbox`, inject lang.
