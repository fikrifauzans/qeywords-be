<?php

namespace App\Http\Controllers\Auth\Configurator;

class AuthConfigurator
{

    const URL_AUTH = '/oauth/token';

    const PARAMETER_EMAIL = 'email';
    const PARAMETER_PASSWORD = 'password';
    const PARAMETER_NAME = 'name';
    const PARAMETER_PASSWORD_CONFIRMED = 'password_confirmation';

    public const ALLOWED_BODY_FIELDS_LOGIN = [
        SELF::PARAMETER_EMAIL,
        SELF::PARAMETER_PASSWORD
    ];
    public const ALLOWED_BODY_FIELDS_REGISTER = [
        SELF::PARAMETER_EMAIL,
        SELF::PARAMETER_PASSWORD,
        SELF::PARAMETER_NAME,
        SELF::PARAMETER_PASSWORD_CONFIRMED
    ];

    public const RULES_BODY_LOGIN = [
        SELF::PARAMETER_EMAIL    => 'required|email',
        SELF::PARAMETER_PASSWORD => 'required',
    ];

    public const RULES_BODY_REGISTER = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ];

    public const TOKEN_TYPE = [''];

    public static function CLIENT_ID()
    {

        return config('passport.personal_access_client.id');
    }

    public static function CLIENT_SECRET()
    {
        return config('passport.personal_access_client.secret');
    }
}
