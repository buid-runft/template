<?php

namespace App\Services\Core;

use App\Models\File;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Services\Core\Contracts\FileStorageInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class FileService
{
    public function __construct(
        protected FileStorageInterface $storage
    ) {}

    public function attachFileToModel(UploadedFile $file, Model $model, string $type = 'general'): File
    {
        $path = $this->generatePath($file, $model, $type);
        $url = $this->storage->put($path, $file);

        return $model->files()->create([
            'filename' => $file->hashName(),
            'original_name' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'disk' => 'public',
            'is_public' => true,
        ]);
    }

    protected function generatePath(UploadedFile $file, Model $model, string $type): string
    {
        $modelName = $model::class;
        $modelId = $model->id;

        $prefix = match($modelName) {
            User::class => 'users',
            Store::class => 'stores',
            Product::class => 'products',
            default => 'general'
        };

        return "{$prefix}/{$modelId}/{$type}/" . $file->hashName();
    }

    public function deleteFile(File $file): bool
    {
        $this->storage->delete($file->path);
        return $file->delete();
    }
}
