<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
        $rules                       = [];
        $rules['carts']              = 'required';
        $rules['carts']              = 'present|array';
        $rules['carts.*.product_id'] = 'required|integer';
        $rules['carts.*.quantity']   = 'required|integer';
        $rules['carts.*.price']      = 'required';
        return $rules;
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
