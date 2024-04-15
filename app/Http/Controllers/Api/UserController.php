<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Interfaces\Repository\UserRepositoryInterface;

class UserController extends Controller
{

    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ){}
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->userRepository->allWithPagination());
    }

    public function edit(string $id): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->userRepository->getById($id)->only('login','email'));
    }

    public function update(UpdateUserRequest $request, string $id): \Illuminate\Http\JsonResponse
    {
        $validate = $request->validated();

        return response()->json([
            'updated' => $this->userRepository->update($id,$validate)
        ]);
    }

    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'deleted' => $this->userRepository->delete($id)
        ]);
    }
}
