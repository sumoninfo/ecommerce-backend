<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderStatusHistoryResource extends JsonResource
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
            'id'         => $this->id,
            'approved'   => $this->approved,
            'processing' => $this->processing,
            'shipped'    => $this->shipped,
            'delivered'  => $this->delivered,
            'rejected'   => $this->rejected,
        ];
    }
}
