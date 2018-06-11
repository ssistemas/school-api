<?php

namespace Emtudo\Units\Files\Providers;

use Emtudo\Support\Units\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    protected $alias = 'files';

    protected $providers = [
        RouteServiceProvider::class,
    ];
}
