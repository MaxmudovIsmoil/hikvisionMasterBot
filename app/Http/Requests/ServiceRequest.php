<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
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
            'blanka_number' => 'required',
            'name' => 'required',
            'phone' => 'required|string|min:9|max:13',
            'area' => 'required',
            'address' => 'required',
            'price' => 'sometimes',
            'location' => 'required',
            'group.*' => 'required',
            'description' => 'required',
        ];
    }
}
