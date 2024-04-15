<?php

namespace App\Repositories;

use App\Exceptions\AdminCannotBeDeletedException;
use App\Exceptions\UserNotFoundException;
use App\Interfaces\Repository\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserRepository implements UserRepositoryInterface
{

    public function allWithPagination(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return User::query()->paginate(10);
    }

    public function getById(int $id): User
    {
        $user = User::query()->find($id);

        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function update(int $id, array $attributes): bool
    {
        $user = $this->getById($id);
        return $user->update($attributes);
    }

    public function delete(int $id):bool
    {
        if($id == 1) {
            throw new AdminCannotBeDeletedException();
        }

        $user = $this->getById($id);

        return $user->delete();
    }
}
