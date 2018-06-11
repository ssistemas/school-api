<?php

namespace Emtudo\Units\Search\Providers;

use Emtudo\Support\Units\ServiceProvider;
use Emtudo\Units\Search;

class UnitServiceProvider extends ServiceProvider
{
    protected $providers = [
        Search\Schools\Providers\RouteServiceProvider::class,
        Search\Courses\Providers\RouteServiceProvider::class,
        Search\Users\Providers\RouteServiceProvider::class,
        Search\Transports\Providers\RouteServiceProvider::class,
    ];
}
