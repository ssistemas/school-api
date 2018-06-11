<?php

namespace Emtudo\Units\Core\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'core';

    protected $providers = [
        RouteServiceProvider::class,
    ];

    public function register()
    {
        $this->app->bind('path.public', function () {
            return base_path('public_html');
        });

        parent::register();
    }
}
