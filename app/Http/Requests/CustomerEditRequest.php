<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,',
            'phone' => 'required|string|max:20',
            'country' => 'required|string|max:100',

            'addresses' => 'required|array|min:1',
            'addresses.*.id' => 'nullable|exists:customer_address,id',
            'addresses.*.address_no' => 'required|string|max:50',
            'addresses.*.street' => 'required|string|max:255',
            'addresses.*.city' => 'required|string|max:255',
            'addresses.*.state' => 'required|string|max:255',
            'addresses.*.country' => 'required|string|max:100',
            'addresses.*.zip_code' => 'required|string|max:20',
        ];
    }
}
