<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'license_plate' => $this->license_plate, // Primary Key
            'brand' => $this->brand,
            'type' => $this->type,
            'customer_id' => $this->customer_id,
            'car_image' => $this->car_image ? asset('storage/' . $this->car_image) : null, // Link ke gambar
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
