<?php

namespace Emtudo\Units\Tenant\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'tenant';

    protected $providers = [
        RouteServiceProvider::class,
    ];
}
