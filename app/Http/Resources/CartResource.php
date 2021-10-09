<?php

namespace App\Http\Resources;

use App\Http\Resources\Admin\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'id'       => $this->id,
            'product'  => new ProductResource($this->product),
            'price'    => $this->price,
            'subtotal' => $this->subtotal,
            'quantity' => $this->quantity,

        ];
    }
}
