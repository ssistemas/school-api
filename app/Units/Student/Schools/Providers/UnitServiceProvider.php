<?php

namespace Emtudo\Units\Student\Schools\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'student_schools';

    protected $providers = [
        RouteServiceProvider::class,
    ];
}
