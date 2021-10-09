<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id'               => $this->id,
            'user'             => new UserResource($this->user),
            'customer_email'   => $this->customer_email,
            'shipping_address' => $this->shipping_address,
            'sub_total'        => $this->sub_total,
            'total_quantity'   => $this->total_quantity,
            'discount'         => $this->discount,
            'shipping_cost'    => $this->shipping_cost,
            'grand_total'      => $this->grand_total,
            'order_note'       => $this->order_note,
            'status'           => $this->status,
        ];
    }
}
