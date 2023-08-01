<?php

use Dmn\Txtbox\Client;
use Dmn\Txtbox\Examples\SmsNotification;
use Dmn\Txtbox\ServiceProvider;
use Dmn\Txtbox\Txtbox;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Notification;
use Orchestra\Testbench\TestCase;

class ClientTest extends TestCase
{
    /**
     * @inheritDoc
     */
    protected function getEnvironmentSetUp($app)
    {
        $config = require __DIR__ . '/../config/txtbox.php';
        $app['config']->set('txtbox', $config);
    }

    /**
     * @inheritDoc
     */
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    /**
     * Get CGI instance
     *
     * @return Client
     */
    protected function service(): Client
    {
        return $this->app->make(Txtbox::class);
    }

    /**
     * @test
     * @testdox Dependency
     *
     * @return void
     */
    public function dependency(): void
    {
        $this->assertInstanceOf(Client::class, $this->service());
    }

    /**
     * @test
     * @testdox It can send sms
     *
     * @return void
     */
    public function sendSuccess(): void
    {
        Client::mockResponse();
        $response = $this->service()->send(
            '09661231231',
            'test message'
        );

        $this->assertNull($response);
    }

    /**
     * @test
     * @testdox It can notify via channel
     *
     * @return void
     */
    public function sendSmsViaChannel(): void
    {
        Client::mockResponse();

        $notification = Notification::send([[
            'mobile_number' => '09661231231',
        ]], new SmsNotification());

        $this->assertNull($notification);
    }

    /**
     * @test
     * @testdox It can notify via channel queue responses
     *
     * @return void
     */
    public function sendSmsViaChannelQueueResponses(): void
    {
        Client::mockQueueResponse([[], []]);

        $notification = Notification::send([[
            'mobile_number' => '09661231231',
        ]], new SmsNotification());

        $this->assertNull($notification);

        $notification = Notification::send([[
            'mobile_number' => '09661231231',
        ]], new SmsNotification());

        $this->assertNull($notification);
    }
}
