<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserStoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'job' => 'required',
            'name' => 'required',
            'phone' => 'required|size:9|unique:users,phone',
            'address' => 'sometimes',
            'status' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:3',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'username.required' => 'The username is required.',
            'username.unique' => 'The username is already exists.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password field must be at least :min characters.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'  => false,
            'message'  => 'Validation errors',
            'errors'   => $validator->errors()
        ]));
    }
}
