<?php

namespace App\Services\External\Contracts;

interface MlmApiClientInterface
{
    public function verifyMember(string $mlmId): array;
    public function getPvPoints(string $mlmId): array;
    public function reportSnowballPoints(string $mlmId, array $data): array;
}
