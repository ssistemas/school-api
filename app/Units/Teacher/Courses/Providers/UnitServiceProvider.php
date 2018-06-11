<?php

namespace Emtudo\Units\Teacher\Courses\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'teacher_courses';

    protected $providers = [
        RouteServiceProvider::class,
    ];
}
