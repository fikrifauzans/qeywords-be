<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorMessage;
use App\Exceptions\ErrorResponse;
use App\Exceptions\ErrorStatus;
use Error;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;



class Controller extends BaseController
{
    use AuthorizesRequests;
    const  DEFAULT_ALLOW_REQUEST = ['limit', 'page', 'table', 'orderBy', 'sortBy', 'search'];



    protected function validateRequest(Request $request, array $allowedFields, array $rules)
    {
        $invalidFields = array_diff(array_keys($request->all()), [...$allowedFields, ...Self::DEFAULT_ALLOW_REQUEST]);

        if (!empty($invalidFields)) {
            throw new ErrorResponse(ErrorMessage::INVALID_PARAMS($invalidFields), ErrorStatus::INVALID);
        }

        try {
            $request->validate($rules);
        } catch (\Throwable $th) {

            throw new ErrorResponse($th->getMessage(), ErrorStatus::INVALID);
        }

    }

    protected function validatePermission(string $method)
    {
        return '';
    }
}
