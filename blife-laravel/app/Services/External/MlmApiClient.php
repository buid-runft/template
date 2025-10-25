<?php

namespace App\Services\External;

use App\Services\External\Contracts\MlmApiClientInterface;
use App\Services\External\Http\MlmHttpClient;

class MlmApiClient implements MlmApiClientInterface
{
    public function __construct(
        protected MlmHttpClient $httpClient
    ) {}

    public function verifyMember(string $mlmId): array
    {
        return $this->httpClient->get('/members/verify', [
            'query' => ['mlm_id' => $mlmId]
        ]);
    }

    public function getPvPoints(string $mlmId): array
    {
        return $this->httpClient->get("/members/{$mlmId}/pv-points");
    }

    public function reportSnowballPoints(string $mlmId, array $data): array
    {
        return $this->httpClient->post("/members/{$mlmId}/snowball-points", $data);
    }
}
