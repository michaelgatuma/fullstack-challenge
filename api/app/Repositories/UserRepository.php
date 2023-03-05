<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
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
    public function getUserById($userId):User
    {
        return User::findOrFail($userId);
    }
}
