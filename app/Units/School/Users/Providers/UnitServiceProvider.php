<?php

namespace Emtudo\Units\School\Users\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'school_users';

    protected $providers = [
        RouteServiceProvider::class,
    ];
}
