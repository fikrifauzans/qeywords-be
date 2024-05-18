<?php

namespace App\Repositories;

use App\Exceptions\ErrorResponse;
use App\Handler\Files\Base64ObjectHandler;
use Mockery\Undefined;

class BaseRepository
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public const DEFAULT_LIMIT = 0;
    public const DEFAULT_ORDER_BY = 'id';
    public const DEFAULT_SORT_BY = 'DESC';
    public const PARAMETER_LIMIT = 'limit';
    public const PARAMETER_ORDER_BY = 'orderBy';
    public const PARAMETER_SORT_BY = 'sortBy';
    public  const DEFAULT_VALUE = NULL;

    function paginate($query,  $request)
    {
        if (isset($request[SELF::PARAMETER_LIMIT])) return $query->paginate($request[SELF::PARAMETER_LIMIT]);
        else return $query->paginate(self::DEFAULT_LIMIT);
    }

    function orderBy($query, $request)
    {
        if ($request[SELF::PARAMETER_ORDER_BY]) return $query->orderBy($request[SELF::PARAMETER_ORDER_BY], $request[SELF::PARAMETER_SORT_BY]);
        else return $query->orderBy(SELF::DEFAULT_ORDER_BY, SELF::DEFAULT_SORT_BY);
    }

    function searchAllFillableData($query, $request)
    {
        try {

            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                foreach ($this->model->getFillable() as $column) {
                    $query->orWhere($column, 'like', '%' . $searchTerm . '%');
                }
            });
        } catch (\Throwable $th) {
            throw new ErrorResponse($th->getMessage());
        }
    }

    /**
     * Retrieve an input item from the request.
     *
     * @param  string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function base64SaveObject($fileRequest, $storagePath = 'storage')
    {

        if (empty($fileRequest) || $fileRequest === null || !isset($fileRequest['base64'])) return json_encode($fileRequest);
        else {
            $baseHandler = new Base64ObjectHandler($fileRequest, $storagePath);
            $baseHandler->setObjectValueBase64();
            return  $baseHandler->storeAndGetObject();
        }
    }
}
