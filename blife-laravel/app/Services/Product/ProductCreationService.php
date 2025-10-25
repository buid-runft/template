<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Models\ProductSnowballSetting;
use App\Models\Store;
use App\Services\Core\FileService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCreationService
{
    public function __construct(
        protected FileService $fileService,
        protected ProductAssetService $assetService
    ) {}

    public function createProduct(Store $store, array $data): Product
    {
        return DB::transaction(function () use ($store, $data) {
            $product = Product::create([
                'store_id' => $store->id,
                'category_id' => $data['category_id'] ?? null,
                'name' => $data['name'],
                'slug' => $this->generateProductSlug($data['name'], $store->id),
                'sku' => $this->generateSku($data['name'], $store->id),
                'description' => $data['description'] ?? null,
                'short_description' => $data['short_description'] ?? null,
                'price' => $data['price'],
                'compare_at_price' => $data['compare_at_price'] ?? null,
                'cost_price' => $data['cost_price'] ?? null,
                'stock_quantity' => $data['stock_quantity'] ?? 0,
                'track_quantity' => $data['track_quantity'] ?? true,
                'allow_backorder' => $data['allow_backorder'] ?? false,
                'is_active' => false, // ต้องรอ approve ก่อน
                'is_approved' => false,
            ]);

            // จัดการอัปโหลดรูปภาพ
            if (isset($data['main_image']) && $data['main_image'] instanceof UploadedFile) {
                $mainImage = $this->assetService->handleMainImageUpload($data['main_image'], $product);
                $product->update(['main_image' => $mainImage]);
            }

            if (!empty($data['gallery_images']) && is_array($data['gallery_images'])) {
                $galleryPaths = [];
                foreach ($data['gallery_images'] as $image) {
                    if ($image instanceof UploadedFile) {
                        $galleryPaths[] = $this->assetService->handleGalleryUpload($image, $product);
                    }
                }
                $product->update(['gallery_images' => $galleryPaths]);
            }

            // สร้าง snowball setting
            $this->createSnowballSetting($product, $data['snowball_setting'] ?? []);

            return $product->fresh();
        });
    }

    protected function generateProductSlug(string $name, int $storeId): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;

        $count = 1;
        while (Product::where('slug', $slug)->where('store_id', $storeId)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    protected function generateSku(string $name, int $storeId): string
    {
        $prefix = 'PROD' . $storeId;
        $suffix = strtoupper(Str::random(6));
        return $prefix . '-' . $suffix;
    }

    protected function createSnowballSetting(Product $product, array $settingData): void
    {
        ProductSnowballSetting::create([
            'product_id' => $product->id,
            'snowball_plan_type' => $settingData['plan_type'] ?? 0,
            'custom_multiplier' => $settingData['custom_multiplier'] ?? null,
            'fixed_points_per_unit' => $settingData['fixed_points_per_unit'] ?? null,
            'use_custom_calculation' => $settingData['use_custom_calculation'] ?? false,
            'min_quantity_for_points' => $settingData['min_quantity_for_points'] ?? 1,
            'max_points_per_product' => $settingData['max_points_per_product'] ?? null,
        ]);
    }
}
