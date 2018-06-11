<?php

namespace Emtudo\Units\School\Dashboard\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'school_dashboard';

    protected $providers = [
        RouteServiceProvider::class,
    ];
}
