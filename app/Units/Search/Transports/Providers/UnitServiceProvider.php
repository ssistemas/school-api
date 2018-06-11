<?php

namespace Emtudo\Units\Search\Transports\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'search_transports';

    protected $providers = [
        RouteServiceProvider::class,
    ];
}
