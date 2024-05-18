<?php

namespace App\Repositories\Transaction;

use App\Exceptions\ErrorResponse;

use App\Models\Transaction\InvoiceModel;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class InvoiceRepository extends BaseRepository
{
    protected InvoiceModel $model;

    public function __construct(InvoiceModel $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    # @Nakamacoda - F
    public function getAll(Request $request)
    {

        # Ketika Permintaan Sama Dengan Kolom
        $query = $this->model
            ->when(isset($request->user_id), fn ($query) => $query->where('user_id', $request->user_id))
            ->when(isset($request->price), fn ($query) => $query->where('price', $request->price))
            ->when(isset($request->duration), fn ($query) => $query->where('duration', $request->duration));

        # Pencarian Query
        if ($request->has('search')) $this->searchAllFillableData($query, $request);

        $this->orderBy($query, $request);
        return $this->paginate($query, $request);
    }

    # @Nakamacoda - F
    public function getById(int $id)
    {
        return $this->model->with('user')->find($id);
    }

    # @Nakamacoda - F
    public function create(Request $request)
    {
        $data = new $this->model;
        $data->fill($request->all());
        // dd($data);
        $data->save();
        return $data;
    }

    # @Nakamacoda - F
    public function update(int $id, Request $request)
    {
        $data = $this->model->find($id);
        $data->fill($request->all());
        $data->save();
        return $data;
    }

    # @Nakamacoda - F
    public function delete(int $id)
    {
        return $this->model->destroy($id);
    }
}
