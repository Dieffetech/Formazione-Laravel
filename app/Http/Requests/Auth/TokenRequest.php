<?php

namespace App\Http\Requests\Auth;

use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Validator;

class TokenRequest extends FormRequest
{
    use ValidationTrait;

    public function rules()
    {
        return [
            'username' => ['required', 'max:255', 'regex:/^\S*$/u'],
            'password' => 'required'
        ];
    }
    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator) {
        throw new HttpResponseException(response()->json(["success" => false,"errors" => $validator->errors()], 422));
    }
}
