<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function create(array $payload): ?Model;

    public function findById(int $id, array $columns = ['*'], array $relations = [], array $appends = []): ?Model;

    public function newInstance(Model $model): static;
}
