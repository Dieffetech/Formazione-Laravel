<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Validation\Validator;

class ValidationException extends Exception
{
    public Validator|null $validator = null;

    public $code = 400;
    public $message = 'Errore validazione.';
    public $data = null;

    public function __construct(Validator|null $validator = null)
    {
        if ($validator !== null) {
            $this->validator = $validator;
            $this->data = $this->validator->errors();
        }

        parent::__construct();
    }
}
