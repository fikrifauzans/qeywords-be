<?php

namespace App\Handler\Response;

class ResponseMessage
{

    const SHOW_DEFAULT_MESSAGE = 'Data found';
    const CREATED_DEFAULT_MESSAGE = 'Data has been created';
    const UPDATED_DEFAULT_MESSAGE = 'Data has been updated';
    const DELETED_DEFAULT_MESSAGE = 'Data has been deleted';


    const LOGOUT_MESSAGE = 'logging out';

    const GENERATED_TOKEN_MESSAGE = 'Token generated succesfuly';

    const GENERATED_LOGIN_MESSAGE = 'Login Successfully';

    const GENERATED_LOGOUT_MESSAGE = 'Logout Successfully';

    public static function GetDefaultMessage(string $count = "")
    {
        return "Data found $count";
    }
}
