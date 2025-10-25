<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Services\Core\Contracts\FileStorageInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;

class ProductAssetService
{
    public function __construct(
        protected FileStorageInterface $storage
    ) {}

    public function handleMainImageUpload(UploadedFile $file, Product $product): string
    {
        Validator::make(['image' => $file], [
            'image' => 'required|image|mimes:jpeg,png,webp|max:2048',
        ])->validate();

        $path = "products/{$product->store_id}/{$product->id}/main/" . $file->hashName();
        return $this->storage->put($path, $file);
    }

    public function handleGalleryUpload(UploadedFile $file, Product $product): string
    {
        Validator::make(['gallery' => $file], [
            'gallery' => 'required|image|mimes:jpeg,png,webp|max:5120',
        ])->validate();

        $path = "products/{$product->store_id}/{$product->id}/gallery/" . $file->hashName();
        return $this->storage->put($path, $file);
    }
}
