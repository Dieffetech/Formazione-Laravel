<?php

namespace App\Http\Requests;

use App\Models\Customer;
use App\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class CustomerInsertRequest extends FormRequest
{
    use ValidationTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            "name" => [
                "required",
                "max:255"
            ],
            "surname" => [
                "required",
                "max:255"
            ],
            "email" => [
                "required",
                Rule::unique(Customer::class, 'email'),
            ],
            "password"=> Customer::PASSWORD_VALIDATION
        ];

        return $rules;
    }
    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator) {
        throw new HttpResponseException(response()->json(["success" => false,"errors" => $validator->errors()], 422));
    }
}
