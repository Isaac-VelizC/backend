<?php

namespace App\Exceptions;

use Exception;

class PageNotFoundException extends Exception
{
    protected $message = 'La página solicitada no existe.';
}
