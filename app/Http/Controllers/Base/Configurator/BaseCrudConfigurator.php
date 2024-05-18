<?php

namespace App\Http\Controllers\Base\Configurator;

class BaseCrudConfigurator
{

    # @ Nakamacode
    #
    # this default for permission access *F
    #

    public const PERMISSION_STORE   = 'base-crud-store';
    public const PERMISSION_INDEX   = 'base-crud-index';
    public const PERMISSION_SHOW    = 'base-crud-show';
    public const PERMISSION_UPDATE  = 'base-crud-update';
    public const PERMISSION_DESTROY = 'base-crud-destroy';




    public const ALLOWED_QUERY_PARAMS = [
        'column_integer',
        'column_smallint',
        'column_string',
        'column_boolean',
        'column_float',
        'column_date',
        'column_time',
        'column_datetime',
        'column_text',
        'column_serverside',
        'column_map',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
    public const ALLOWED_REQUEST_FIELDS = [
        'column_integer',
        'column_smallint',
        'column_string',
        'column_boolean',
        'column_float',
        'column_date',
        'column_time',
        'column_datetime',
        'column_text',
        'column_file',
        'column_serverside',
        'column_map',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
    public const RULES_QUERIES = [
        'column_integer' => '',
        'column_smallint' => '',
        'column_string' => '',
        'column_boolean' => '',
        'column_float' => '',
        'column_date' => '',
        'column_time' => '',
        'column_datetime' => '',
        'column_text' => '',
        'column_file' => '',
        'column_serverside' => '',
        'column_map' => '',
    ];
    public const RULES_BODY_COMMON = [
        'column_integer' => 'required',
        'column_smallint' => 'required',
        'column_string' => 'required',
        'column_boolean' => 'required',
        'column_float' => 'required',
        'column_date' => 'required',
        'column_time' => 'required',
        'column_datetime' => 'required',
        'column_text' => 'required',
        'column_file' => '',
        'column_serverside' => 'required',
        'column_map' => 'required'
    ];
}
