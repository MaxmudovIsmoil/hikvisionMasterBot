<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'dep' => 'required',
            'pos' => 'required',
            'name' => 'required|string|max:255',
            'email'=> ['required', 'email', Rule::unique('users', 'email')->ignore($this->user)],
            'login'=> ['required', Rule::unique('users', 'login')->ignore($this->user)],
//            'username' => 'required|unique:users,username,' . $this->user,
            'password' => 'sometimes',
            'language' => 'required',
            'ldap' => 'required',
            'status' => 'required',
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
