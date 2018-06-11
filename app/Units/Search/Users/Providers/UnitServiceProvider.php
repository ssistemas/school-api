<?php

namespace Emtudo\Units\Search\Users\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'search_users';

    protected $providers = [
        RouteServiceProvider::class,
    ];
}
