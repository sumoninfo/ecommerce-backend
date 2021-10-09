<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
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
            'id'          => $this->id,
            'name'        => $this->name,
            'price'       => $this->price,
            'quantity'    => $this->quantity,
            'description' => $this->description,
            'image'       => Storage::disk('public')->url("products/{$this->image}"),
        ];
    }
}
