<?php

namespace App\Http\Controllers\Transaction\Configurator;

class InvoiceConfigurator
{

    # @ Nakamacode
    #
    # this default for permission access *F
    #

    public const PERMISSION_STORE   = 'invoice-crud-store';
    public const PERMISSION_INDEX   = 'invoice-crud-index';
    public const PERMISSION_SHOW    = 'invoice-crud-show';
    public const PERMISSION_UPDATE  = 'invoice-crud-update';
    public const PERMISSION_DESTROY = 'invoice-crud-destroy';

    public const ALLOWED_QUERY_PARAMS = [
        'user_id',
        'price',
        'duration',
    ];

    public const ALLOWED_REQUEST_FIELDS = [
        'user_id',
        'price',
        'duration',
    ];

    public const RULES_QUERIES = [
        'user_id' => '',
        'price' => '',
        'duration' => '',
    ];

    public const RULES_BODY_COMMON = [
        'user_id' => 'required',
        'price' => 'required',
        'duration' => 'required',
    ];
}
