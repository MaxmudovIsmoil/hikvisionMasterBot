<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'phone' => 'required|max:9|min:9',
            'photo' => 'required|mimes:png,jpg,jpeg,csv',
            'username' => 'required|min:3|unique:users,username',
            'password' => 'required|min:3',
            'instances.*' => 'required'
        ];
    }
}
