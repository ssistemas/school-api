<?php

namespace Emtudo\Support\Response\Json\Providers;

use Emtudo\Support\Response\Json\Contracts\Factory as FactoryContract;
use Emtudo\Support\Response\Json\Factory;
use Illuminate\Support\ServiceProvider;

class JsonResponseServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton(FactoryContract::class, Factory::class);
    }
}
