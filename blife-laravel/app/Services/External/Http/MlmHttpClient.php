<?php

namespace App\Services\External\Http;

use App\Exceptions\MlmApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

class MlmHttpClient
{
    protected Client $client;
    protected string $baseUrl;
    protected string $token;
    protected int $timeout;

    public function __construct()
    {
        $this->baseUrl = config('mlm.base_url');
        $this->token = config('mlm.token');
        $this->timeout = config('mlm.timeout', 30);

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => $this->timeout,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
                'Accept' => 'application/json',
                'User-Agent' => 'BlifeHealthy/1.0',
            ],
        ]);
    }

    public function get(string $uri, array $options = []): array
    {
        return $this->send('GET', $uri, $options);
    }

    public function post(string $uri, array $data = []): array
    {
        return $this->send('POST', $uri, ['json' => $data]);
    }

    protected function send(string $method, string $uri, array $options = []): array
    {
        try {
            Log::info('MLM API Request', [
                'method' => $method,
                'uri' => $uri,
                'options' => $options,
            ]);

            $response = $this->client->request($method, $uri, $options);
            $body = json_decode($response->getBody()->getContents(), true);

            Log::info('MLM API Response', [
                'status' => $response->getStatusCode(),
                'body' => $body,
            ]);

            return $body;
        } catch (GuzzleException $e) {
            Log::error('MLM API Error', [
                'uri' => $uri,
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);

            throw new MlmApiException("MLM API request failed: " . $e->getMessage(), $e->getCode(), $e);
        }
    }
}
