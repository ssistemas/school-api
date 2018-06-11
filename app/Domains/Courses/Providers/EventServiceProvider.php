<?php

namespace Emtudo\Domains\Courses\Providers;

use Emtudo\Domains\Courses\Listerners\SetProfileStudent;
use Emtudo\Domains\Cousers\Events\EnrollmentCreated;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        EnrollmentCreated::class => [
            SetProfileStudent::class,
        ],
    ];
}
