<?php

namespace App\Providers;

use App\Repositories\Client\ClientRepository;
use App\Repositories\Client\ClientRepositoryInterface;
use App\Services\Client\ClientService;
use App\Services\Client\ClientServiceInterface;
use Illuminate\Support\ServiceProvider;

/**
 * Class ClientServiceProvider
 * @package App\Providers
 */
class ClientServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ClientServiceInterface::class, ClientService::class);
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
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
