<?php

namespace Emtudo\Units\School\Courses\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'school_courses';

    protected $providers = [
        RouteServiceProvider::class,
    ];
}
