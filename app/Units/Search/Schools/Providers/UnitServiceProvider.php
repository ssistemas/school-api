<?php

namespace Emtudo\Units\Search\Schools\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'school_schools';

    protected $providers = [
        RouteServiceProvider::class,
    ];
}
