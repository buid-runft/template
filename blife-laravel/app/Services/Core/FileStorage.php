<?php

namespace App\Services\Core;

use App\Services\Core\Contracts\FileStorageInterface;
use Illuminate\Support\Facades\Storage;

class FileStorage implements FileStorageInterface
{
    public function put(string $path, $contents, array $options = []): string
    {
        return Storage::put($path, $contents, $options);
    }

    public function get(string $path): string
    {
        return Storage::get($path);
    }

    public function delete(string $path): bool
    {
        return Storage::delete($path);
    }

    public function getUrl(string $path): string
    {
        return Storage::url($path);
    }

    public function exists(string $path): bool
    {
        return Storage::exists($path);
    }
}
