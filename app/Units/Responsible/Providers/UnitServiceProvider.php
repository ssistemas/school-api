<?php

namespace Emtudo\Units\Responsible\Providers;

use Emtudo\Support\Units\ServiceProvider;
use Emtudo\Units\Responsible;

class UnitServiceProvider extends ServiceProvider
{
    protected $providers = [
        Responsible\Users\Providers\RouteServiceProvider::class,
    ];
}
