<?php

namespace App\Providers;

use App\Repositories\DepartmentRepository;
use App\Repositories\DepartmentRepositoryInterface;
use App\Repositories\VisitorRepository;
use App\Repositories\VisitorRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(VisitorRepositoryInterface::class, VisitorRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class); 
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
