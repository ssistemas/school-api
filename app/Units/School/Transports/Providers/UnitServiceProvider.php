<?php

namespace Emtudo\Units\School\Transports\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'school_transports';

    protected $providers = [
        RouteServiceProvider::class,
    ];
}
