<?php

namespace Emtudo\Domains\Tenants\Providers;

use Emtudo\Domains\Tenants\Events\CreateCreated;
use Emtudo\Domains\Tenants\Listerners\CreateStandardCourses;
use Emtudo\Domains\Tenants\Listerners\CreateStandardSubjects;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CreateCreated::class => [
            CreateStandardCourses::class,
            CreateStandardSubjects::class,
        ],
    ];
}
