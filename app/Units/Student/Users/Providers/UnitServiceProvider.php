<?php

namespace Emtudo\Units\Student\Users\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'student_users';

    protected $providers = [
        RouteServiceProvider::class,
    ];
}
