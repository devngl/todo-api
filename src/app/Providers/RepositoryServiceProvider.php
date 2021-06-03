<?php

namespace App\Providers;

use App\Repositories\Eloquent;
use App\Repositories\Eloquent\Interfaces\CustomerRepository;
use App\Repositories\RepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(RepositoryInterface::class, Eloquent\BaseRepository::class);
        $this->app->bind(CustomerRepository::class, Eloquent\CustomerRepository::class);
    }
}
