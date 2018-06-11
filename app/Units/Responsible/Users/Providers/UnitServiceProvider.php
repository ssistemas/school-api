<?php

namespace Emtudo\Units\Responsible\Users\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'responsible_users';

    protected $providers = [
        RouteServiceProvider::class,
    ];
}
