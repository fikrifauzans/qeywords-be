<?php

namespace App\Exceptions;

class ErrorMessage
{
    public const AUTH_FAILED = "Email or password not match";
    public const AUTH_FAILED_GENERATE_TOKEN = "Generate token fail";

    public static function INVALID_PARAMS($params)
    {


        return  'Invalid fields: ' . implode(', ', $params);
    }
}
