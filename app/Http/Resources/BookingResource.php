<?php

namespace App\Http\Resources;

use App\Http\Resources\Admin\RoomResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'id'              => $this->id,
            'booking_no'      => $this->booking_no,
            'date'            => $this->date,
            'user'            => new UserResource($this->user),
            'room'            => new RoomResource($this->room),
            'customer_email'  => $this->customer_email,
            'customer_number' => $this->customer_number,
            'check_in'        => $this->check_in,
            'check_out'       => $this->check_out,
            'address'         => $this->address,
            'sub_total'       => $this->sub_total,
            'grand_total'     => $this->grand_total,
            'note'            => $this->note,
            'status'          => $this->status,
        ];
    }
}
