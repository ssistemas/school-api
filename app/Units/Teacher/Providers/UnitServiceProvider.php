<?php

namespace Emtudo\Units\Teacher\Providers;

use Emtudo\Support\Units\ServiceProvider;
use Emtudo\Units\Teacher;

class UnitServiceProvider extends ServiceProvider
{
    protected $providers = [
        Teacher\Courses\Providers\RouteServiceProvider::class,
        Teacher\Users\Providers\RouteServiceProvider::class,
    ];
}
