<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;



class AuthRepository extends BaseRepository
{

    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    function findExistingUser(Request $request)
    {
        $user = $this->model->where('email', $request->input('email'))->first();
        return $user;
    }

    function registerNewUser(array $data)
    {
        $user = $this->model->create($data);
        return $user;
    }
}
