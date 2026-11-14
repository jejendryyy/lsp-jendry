<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_id' => [
                'nullable',
                'integer',
                'exists:products,id',
            ],
            'sender_name' => ['required_without:product_id', 'nullable', 'string', 'max:100'],
            'sender_email' => ['required_without:product_id', 'nullable', 'email:rfc', 'max:150'],
            'sender_phone' => ['required', 'string', 'max:30'],
            'message' => ['nullable', 'string', 'max:5000'],
        ];
    }

    public function messages()
    {
        return ['sender_phone.required' => 'Nomor Telepon harus diisi'];
    }
}
