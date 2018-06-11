<?php

namespace Emtudo\Units\Search\Courses\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'search_courses';

    protected $providers = [
        RouteServiceProvider::class,
    ];
}
