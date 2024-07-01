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
            'phone' => 'required|min:7|max:13',
            'address' => 'sometimes',
            'status' => 'required',
            'role' => 'required',
            'username' => 'sometimes',
            'password' => 'sometimes',
        ];

        if ($this->input(key: 'role') == 2) {
            $rules['username'] = 'required|unique:users,username';
            $rules['password'] = 'required|min:3';
        }

//        $this->sometimes('username', 'required|unique:users,username', function ($input) {
//            return $input->role == 2;
//        });
//        $this->sometimes('password', 'required|min:3', function ($input) {
//            return $input->role == 2;
//        });

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
