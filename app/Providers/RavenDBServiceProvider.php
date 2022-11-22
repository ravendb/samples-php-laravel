<?php

namespace App\Providers;

use App\Services\RavenDBManager;
use App\Services\TaskRepository;
use Illuminate\Support\ServiceProvider;

class RavenDBServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $manager = new RavenDBManager();

        $this->app->singleton(RavenDBManager::class, function ($app) use (&$manager) {
            return $manager;
        });

        $this->app->singleton(TaskRepository::class, function ($app) use ($manager) {
            return new TaskRepository($manager);
        });
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
