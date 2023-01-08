<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
            'name'              => 'required|max:100',
            'price'             => 'required|numeric',
            'size'              => 'required',
            'maximum_occupancy' => 'required|integer',
            'description'       => 'nullable',
            'image'             => 'nullable',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'          => 'The Name field is required.',
            'name.price'             => 'The Price field is required.',
            'name.size'              => 'The Size field is required.',
            'name.maximum_occupancy' => 'The Maximum Occupancy field is required.',
        ];
    }
}
