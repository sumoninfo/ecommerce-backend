<?php

namespace App\Http\Resources;

use App\Http\Resources\Admin\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'product'   => new ProductResource($this->product),
            'price'     => $this->price,
            'quantity'  => $this->quantity,
            'sub_total' => $this->sub_total,
        ];
    }
}
