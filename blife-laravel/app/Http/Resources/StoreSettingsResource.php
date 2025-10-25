<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreSettingsResource extends JsonResource
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
            'store_id' => $this->store_id,
            'currency' => $this->currency,
            'timezone' => $this->timezone,
            'language' => $this->language,
            'tax_rate' => $this->tax_rate,
            'shipping_fee' => $this->shipping_fee,
            'free_shipping_threshold' => $this->free_shipping_threshold,
            'is_active' => $this->is_active,
            'maintenance_mode' => $this->maintenance_mode,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
