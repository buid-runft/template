<?php

namespace App\Providers;

use App\Services\External\Contracts\MlmApiClientInterface;
use App\Services\External\MlmApiClient;
use Illuminate\Support\ServiceProvider;

class MlmApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(MlmApiClientInterface::class, function ($app) {
            return new MlmApiClient(
                new \App\Services\External\Http\MlmHttpClient()
            );
        });
    }

    public function boot(): void
    {
        //
    }
}
