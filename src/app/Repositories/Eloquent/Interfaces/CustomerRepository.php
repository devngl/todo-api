<?php

namespace App\Repositories\Eloquent\Interfaces;

use App\Models\Customer;
use App\Repositories\RepositoryInterface;

interface CustomerRepository extends RepositoryInterface
{
    public function findByEmail(string $email, array $columns = ['*'], array $with = [], array $appends = []): ?Customer;

    public function logout(): int;
}
