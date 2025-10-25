<?php

namespace App\Services\Store;

use App\Models\Store;
use App\Services\Core\Contracts\FileStorageInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;

class StoreAssetService
{
    public function __construct(
        protected FileStorageInterface $storage
    ) {}

    public function handleLogoUpload(UploadedFile $file, Store $store): string
    {
        Validator::make(['logo' => $file], [
            'logo' => 'required|image|mimes:jpeg,png,webp|max:2048',
        ])->validate();

        $path = "stores/{$store->id}/logo/" . $file->hashName();
        return $this->storage->put($path, $file);
    }

    public function handleCoverImageUpload(UploadedFile $file, Store $store): string
    {
        Validator::make(['cover' => $file], [
            'cover' => 'required|image|mimes:jpeg,png,webp|max:5120',
        ])->validate();

        $path = "stores/{$store->id}/cover/" . $file->hashName();
        return $this->storage->put($path, $file);
    }

    public function handleDocumentUpload(UploadedFile $file, Store $store, string $type): string
    {
        $allowedMimes = match($type) {
            'business_reg' => ['pdf', 'jpeg', 'png'],
            'id_card' => ['pdf', 'jpeg', 'png'],
            'bank_doc' => ['pdf', 'jpeg', 'png'],
            default => ['pdf', 'jpeg', 'png']
        };

        Validator::make(['doc' => $file], [
            'doc' => 'required|mimes:' . implode(',', $allowedMimes) . '|max:10240',
        ])->validate();

        $path = "stores/{$store->id}/documents/{$type}/" . $file->hashName();
        return $this->storage->put($path, $file);
    }
}
