<?php

namespace App\Traits;

use App\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;

trait ValidationTrait
{
    /**
     * @throws ValidationException
     */
    public function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator);
    }
}
