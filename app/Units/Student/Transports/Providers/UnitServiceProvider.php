<?php

namespace Emtudo\Units\Student\Transports\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'student_transports';

    protected $providers = [
        RouteServiceProvider::class,
    ];
}
