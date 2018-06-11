<?php

namespace Emtudo\Units\Search\Calendars\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'search_calendars';

    protected $providers = [
        RouteServiceProvider::class,
    ];
}
