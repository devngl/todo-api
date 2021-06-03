<?php

namespace App\Repositories\Eloquent;

use App\Models\Customer;

class CustomerRepository extends BaseRepository implements Interfaces\CustomerRepository
{
    protected $model;

    public function __construct(Customer $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function findByEmail(string $email, array $columns = ['*'], array $with = [], array $appends = []): ?Customer
    {
        return $this->model->with($with)
            ->select($columns)
            ->firstWhere('email', $email)
            ->append($appends);
    }

    public function logout(): int
    {
        return $this->model->tokens()->delete();
    }
}
