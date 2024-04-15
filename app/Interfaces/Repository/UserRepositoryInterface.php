<?php

namespace App\Interfaces\Repository;

use App\Models\User;

interface UserRepositoryInterface
{
    public function allWithPagination(): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
    public function getById(int $id): User;
    public function update(int $id,array $attributes): bool;
    public function delete(int $id): bool;
}
