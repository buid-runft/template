<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'sku' => $this->sku,
            'stock_quantity' => $this->stock_quantity,
            'stock_status' => $this->stock_status,
            'weight' => $this->weight,
            'dimensions' => $this->dimensions,
            'images' => $this->images,
            'featured_image' => $this->featured_image,
            'gallery' => $this->gallery,
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'store' => new StoreResource($this->whenLoaded('store')),
            'variants' => ProductVariantResource::collection($this->whenLoaded('variants')),
            'reviews' => ProductReviewResource::collection($this->whenLoaded('reviews')),
            'average_rating' => $this->reviews_avg_rating ?? 0,
            'review_count' => $this->reviews_count ?? 0,
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
