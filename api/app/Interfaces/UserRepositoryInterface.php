<?php

namespace App\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    /**
     * Return paginated query results of all users
     * @param $perPage
     * @return array|LengthAwarePaginator
     */
    public function getAllUsers($perPage): array|LengthAwarePaginator;

    /**
     * Return a user by the provided id
     * @param $userId
     * @return mixed
     */
    public function getUserById($userId): array;
}
