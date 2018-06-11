<?php

namespace Emtudo\Units\School\Providers;

use Emtudo\Support\Units\ServiceProvider;
use Emtudo\Units\School;

class UnitServiceProvider extends ServiceProvider
{
    protected $providers = [
        School\Calendars\Providers\RouteServiceProvider::class,
        School\Courses\Providers\RouteServiceProvider::class,
        School\Schools\Providers\RouteServiceProvider::class,
        School\Users\Providers\RouteServiceProvider::class,
        School\Transports\Providers\RouteServiceProvider::class,
        School\Dashboard\Providers\RouteServiceProvider::class,
    ];
}
