<?php

namespace Dmn\Txtbox;

use Dmn\Txtbox\Txtbox;
use GuzzleHttp\Client as HttpClient;

class Client implements Txtbox
{
    protected $httpClient;

    protected string $baseUri;

    protected string $apiKey;

    protected $guzzle;

    public function __construct(array $config)
    {
        $this->baseUri = $config['base_uri'];
        $this->apiKey = $config['api_key'];
        $this->guzzle = $config['guzzle'] ?? [];
    }

    /**
     * Get a instance of the Guzzle HTTP client.
     *
     * @return \GuzzleHttp\Client
     */
    protected function httpClient(): HttpClient
    {
        $this->guzzle['base_uri'] = $this->baseUri;

        if (is_null($this->httpClient)) {
            $this->httpClient = new HttpClient($this->guzzle);
        }

        return $this->httpClient;
    }

    /**
     * {@inheritDoc}
     */
    public function send(string $mobileNumber, string $message): void
    {
        $this->httpClient()->request(
            method: 'POST',
            uri: 'sms/push',
            options: [
                'headers' => [
                    'x-txtbox-auth' => $this->apiKey,
                ],
                'json' => [
                    'number' => $mobileNumber,
                    'message' => $message,
                ],
            ]
        );
    }
}
