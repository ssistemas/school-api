<?php

namespace Emtudo\Units\Student\Providers;

use Emtudo\Support\Units\ServiceProvider;
use Emtudo\Units\Student;

class UnitServiceProvider extends ServiceProvider
{
    protected $providers = [
        Student\Courses\Providers\RouteServiceProvider::class,
        Student\Schools\Providers\RouteServiceProvider::class,
        Student\Users\Providers\RouteServiceProvider::class,
        Student\Transports\Providers\RouteServiceProvider::class,
    ];
}
