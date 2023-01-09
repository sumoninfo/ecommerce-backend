<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'room_id'        => 'required|exists:rooms,id',
            'address'        => 'required',
            'check_in'       => 'required',
            'check_out'      => 'required',
            'customer_number' => 'required'
        ];
    }
}
