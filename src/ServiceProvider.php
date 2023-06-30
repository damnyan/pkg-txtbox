<?php

namespace Dmn\Txtbox;

use Dmn\Txtbox\Client;
use Dmn\Txtbox\Txtbox;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->app->bind(Txtbox::class, function ($app) {
            $config = $app['config']['txtbox'];
            return new Client($config);
        });
    }
}
