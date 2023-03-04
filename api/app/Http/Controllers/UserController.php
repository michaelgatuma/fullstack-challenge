<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(): UserCollection
    {
        return new UserCollection($this->userRepository->getAllUsers());
    }

    public function show(Request $request): UserResource
    {
        $userId = $request->route('id');
        return new UserResource($this->userRepository->getUserById($userId));
    }

}
