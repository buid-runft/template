<?php

namespace App\Providers;

use App\Services\Core\Contracts\FileStorageInterface;
use App\Services\Core\FileStorage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FileStorageInterface::class, FileStorage::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
