<?php

namespace App\Services\Core\Contracts;

interface FileStorageInterface
{
    public function put(string $path, $contents, array $options = []): string;
    public function get(string $path): string;
    public function delete(string $path): bool;
    public function getUrl(string $path): string;
    public function exists(string $path): bool;
}