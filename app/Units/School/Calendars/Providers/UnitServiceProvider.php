<?php

namespace Emtudo\Units\School\Calendars\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'school_calendars';

    protected $providers = [
        RouteServiceProvider::class,
    ];
}
