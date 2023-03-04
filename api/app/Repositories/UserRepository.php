<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements \App\Interfaces\UserRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function getAllUsers($perPage=10):array|LengthAwarePaginator
    {
        return User::paginate($perPage);
    }

    /**
     * @inheritDoc
     */
    public function getUserById($userId):array
    {
        return User::findOrFail($userId);
    }
}
