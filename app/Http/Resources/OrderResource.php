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
            'id'                   => $this->id,
            'order_no'             => $this->order_no,
            'date'                 => $this->date,
            'user'                 => new UserResource($this->user),
            'order_items'          => OrderItemResource::collection($this->orderItems),
            'order_status_history' => new OrderStatusHistoryResource($this->orderStatusHistory),
            'customer_email'       => $this->customer_email,
            'shipping_address'     => $this->shipping_address,
            'sub_total'            => $this->sub_total,
            'discount'             => $this->discount,
            'shipping_cost'        => $this->shipping_cost,
            'grand_total'          => $this->grand_total,
            'note'                 => $this->note,
            'status'               => $this->status,
        ];
    }
}
