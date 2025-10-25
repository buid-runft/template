<?php

namespace App\Services\Core;

use App\Exceptions\FileStorageException;
use App\Services\Core\Contracts\FileStorageInterface;
use Illuminate\Support\Facades\Storage;

class FileStorageService implements FileStorageInterface
{
    protected string $disk;

    public function __construct(string $disk = 'public')
    {
        $this->disk = $disk;
    }

    public function put(string $path, $contents, array $options = []): string
    {
        try {
            Storage::disk($this->disk)->put($path, $contents, $options);
            return $this->getUrl($path);
        } catch (\Exception $e) {
            throw new FileStorageException("Failed to store file: " . $e->getMessage());
        }
    }

    public function get(string $path): string
    {
        if (!$this->exists($path)) {
            throw new FileStorageException("File not found: {$path}");
        }
        return Storage::disk($this->disk)->get($path);
    }

    public function delete(string $path): bool
    {
        try {
            return Storage::disk($this->disk)->delete($path);
        } catch (\Exception $e) {
            throw new FileStorageException("Failed to delete file: " . $e->getMessage());
        }
    }

    public function getUrl(string $path): string
    {
        return Storage::disk($this->disk)->url($path);
    }

    public function exists(string $path): bool
    {
        return Storage::disk($this->disk)->exists($path);
    }
}
