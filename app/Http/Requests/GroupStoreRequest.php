<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GroupStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => "required",
            'capitan_id' => "required",
            'ball' => 'required',
            'phone' => 'required|string|unique:groups,phone|min:9|max:13',
            'level' => 'required',
            'status' => 'required',
            'key.*' => 'required',
            'val.*' => 'required',
            'user.*' => 'sometimes',
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
