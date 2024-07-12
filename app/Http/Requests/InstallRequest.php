<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstallRequest extends FormRequest
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
            'category_id' => 'required',
            'blanka_number' => 'required',
            'name' => 'required',
            'phone' => 'required|string|min:9|max:13',
            'area' => 'required',
            'address' => 'required',
            'price' => 'required|numeric',
            'location' => 'required',
            'group.*' => 'required',
            'description' => 'required',
        ];
    }
}
