<?php

namespace App\Repositories\Base;

use App\Exceptions\ErrorResponse;
use App\Models\Base\BaseCrudModel;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class BaseCrudRepository extends BaseRepository
{
    protected BaseCrudModel $model;

    public function __construct(BaseCrudModel $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    # @Nakamacoda - F
    public function getAll(Request $request)
    {



        # When Request Equal With columns
        $query = $this->model
            ->when(isset($request->column_integer), fn ($query) => $query->where('column_integer', $request->column_integer))
            ->when(isset($request->column_smallint), fn ($query) => $query->where('column_smallint', $request->column_smallint))
            ->when(isset($request->column_string), fn ($query) => $query->where('column_string', $request->column_string))
            ->when(isset($request->column_boolean), fn ($query) => $query->where('column_boolean', $request->column_boolean))
            ->when(isset($request->column_float), fn ($query) => $query->where('column_float', $request->column_float))
            ->when(isset($request->column_date), fn ($query) => $query->where('column_date', $request->column_date))
            ->when(isset($request->column_time), fn ($query) => $query->where('column_time', $request->column_time))
            ->when(isset($request->column_datetime), fn ($query) => $query->where('column_datetime', $request->column_datetime))
            ->when(isset($request->column_text), fn ($query) => $query->where('column_text', $request->column_text))
            ->when(isset($request->column_binary), fn ($query) => $query->where('column_binary', $request->column_binary))
            ->when(isset($request->column_serverside), fn ($query) => $query->where('column_serverside', $request->column_serverside))
            ->when(isset($request->column_map), fn ($query) => $query->where('column_map', $request->column_serverside));

        # Query Search
        if ($request->has('search')) $this->searchAllFillableData($query, $request);


        $this->orderBy($query, $request);
        $query->with("ColumnServerside");
        return $this->paginate($query, $request);
    }


    # @Nakamacoda - F
    public function getById(int $id)
    {
        return $this->model->with('ColumnServerside')->find($id);
    }

    # @Nakamacoda - F
    public function create(Request $request)
    {
        # @Nakamacoda - F
        # For Query

        $data =  $this->model;;
        $data->setAttribute('column_integer', $request->input('column_integer', parent::DEFAULT_VALUE));
        $data->setAttribute('column_smallint', $request->input('column_smallint', parent::DEFAULT_VALUE));
        $data->setAttribute('column_string',  $request->input('column_string', parent::DEFAULT_VALUE));
        $data->setAttribute('column_boolean', $request->input('column_boolean', parent::DEFAULT_VALUE));
        $data->setAttribute('column_float', $request->input('column_float', parent::DEFAULT_VALUE));
        $data->setAttribute('column_date', $request->input('column_date', parent::DEFAULT_VALUE));
        $data->setAttribute('column_time', $request->input('column_time', parent::DEFAULT_VALUE));
        $data->setAttribute('column_datetime', $request->input('column_datetime', parent::DEFAULT_VALUE));
        $data->setAttribute('column_text', $request->input('column_text', parent::DEFAULT_VALUE));
        $data->setAttribute('column_binary', $request->input('column_binary', parent::DEFAULT_VALUE));
        $data->setAttribute('column_text', $request->input('column_text', parent::DEFAULT_VALUE));
        $data->setAttribute('column_serverside', $request->input('column_serverside', parent::DEFAULT_VALUE));
        $data->setAttribute('column_file', $this->base64SaveObject($request->input('column_file', parent::DEFAULT_VALUE)));
        $data->setAttribute('column_map', $this->base64SaveObject($request->input('column_map', parent::DEFAULT_VALUE)));
        $data->save();
        # @Nakamacoda - F
        # Return Data
        # -------------------

    }

    # @Nakamacoda - F
    public function update(int $id, Request $request)
    {

        $data =  $this->model->find($id);
        $data->setAttribute('column_integer', $request->input('column_integer', parent::DEFAULT_VALUE));
        $data->setAttribute('column_smallint', $request->input('column_smallint', parent::DEFAULT_VALUE));
        $data->setAttribute('column_string',  $request->input('column_string', parent::DEFAULT_VALUE));
        $data->setAttribute('column_boolean', $request->input('column_boolean', parent::DEFAULT_VALUE));
        $data->setAttribute('column_float', $request->input('column_float', parent::DEFAULT_VALUE));
        $data->setAttribute('column_date', $request->input('column_date', parent::DEFAULT_VALUE));
        $data->setAttribute('column_time', $request->input('column_time', parent::DEFAULT_VALUE));
        $data->setAttribute('column_datetime', $request->input('column_datetime', parent::DEFAULT_VALUE));
        $data->setAttribute('column_text', $request->input('column_text', parent::DEFAULT_VALUE));
        $data->setAttribute('column_serverside', $request->input('column_serverside', parent::DEFAULT_VALUE));
        $data->setAttribute('column_map', $request->input('column_map', parent::DEFAULT_VALUE));
        $data->setAttribute('column_file', $this->base64SaveObject($request->input('column_file', parent::DEFAULT_VALUE)));
        $data->save();

        # @Nakamacoda - F
        # Return Data
        # -------------------
        return $data;
    }

    # @Nakamacoda - F
    public function delete(int $id)
    {

        # @Nakamacoda - F
        # Return Data
        # -------------------
        return $this->model->destroy($id);
    }
}
