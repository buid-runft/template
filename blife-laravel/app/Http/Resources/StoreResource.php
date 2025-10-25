<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
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
            'logo' => $this->logo,
            'banner' => $this->banner,
            'owner' => new UserResource($this->whenLoaded('owner')),
            'profile' => new StoreProfileResource($this->whenLoaded('profile')),
            'settings' => new StoreSettingsResource($this->whenLoaded('settings')),
            'verification' => new StoreVerificationResource($this->whenLoaded('verification')),
            'is_active' => $this->is_active,
            'is_verified' => $this->is_verified,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
