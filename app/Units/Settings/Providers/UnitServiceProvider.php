<?php

namespace Emtudo\Units\Settings\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'settings';

    protected $providers = [
        RouteServiceProvider::class,
    ];
}
