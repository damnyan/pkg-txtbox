<?php

namespace Dmn\Txtbox\Traits;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

trait Testable
{
    /**
     * Mock response
     *
     * @param array $response
     * @param int $status
     * @param array $headers
     * @param bool $isFullPath
     *
     * @return void
     */
    public static function mockResponse(
        string $file = 'send_success.json',
        int $status = 200,
        array $headers = [],
        bool $isFullPath = false
    ): void {
        if ($isFullPath === false) {
            $file = __DIR__ . '/../../tests/Responses/' . $file;
        }

        $mock = new MockHandler([
            new Response($status, $headers, file_get_contents($file)),
        ]);

        $handlerStack = HandlerStack::create($mock);

        app()['config']->set('txtbox.guzzle', ['handler' => $handlerStack]);
    }
}
