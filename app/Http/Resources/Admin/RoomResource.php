<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'price'             => $this->price,
            'size'              => $this->size,
            'maximum_occupancy' => $this->maximum_occupancy,
            'description'       => $this->description,
            'amenities'       => AmenityResource::collection($this->amenities),
            'image'             => Storage::disk('public')->url("rooms/{$this->image}")
        ];
    }
}
