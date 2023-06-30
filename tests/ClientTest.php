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
     * Mock response
     *
     * @param array $response
     * @param int $status
     * @param array $headers
     *
     * @return void
     */
    protected function mockResponse(
        array $response,
        int $status = 200,
        array $headers = []
    ): void {
        $mock = new MockHandler([
            new Response($status, $headers, json_encode($response)),
        ]);
        $handlerStack = HandlerStack::create($mock);

        $this->app['config']->set('txtbox.guzzle', ['handler' => $handlerStack]);
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
        $this->mockResponse(json_decode(
            file_get_contents(__DIR__ . '/Responses/send_success.json'),
            true
        ));

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
        $this->mockResponse(json_decode(
            file_get_contents(__DIR__ . '/Responses/send_success.json'),
            true
        ));

        $notification = Notification::send([[
            'mobile_number' => '09661231231',
        ]], new SmsNotification());

        $this->assertNull($notification);
    }
}
