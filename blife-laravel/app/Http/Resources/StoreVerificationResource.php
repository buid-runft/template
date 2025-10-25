<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreVerificationResource extends JsonResource
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
            'verification_type' => $this->verification_type,
            'status' => $this->status,
            'submitted_at' => $this->submitted_at,
            'verified_at' => $this->verified_at,
            'rejected_at' => $this->rejected_at,
            'rejection_reason' => $this->rejection_reason,
            'documents' => $this->documents,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
