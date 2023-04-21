<?php

namespace App\Exceptions;

use Exception;

class WrongCredentialsException extends Exception
{
    public $code = 403;
    public $message = 'Credenziali sbagliate o account non verificato!';
}
