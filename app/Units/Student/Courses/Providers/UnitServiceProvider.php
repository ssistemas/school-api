<?php

namespace Emtudo\Units\Student\Courses\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'student_courses';

    protected $providers = [
        RouteServiceProvider::class,
    ];
}
