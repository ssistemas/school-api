<?php

namespace Emtudo\Units\School\Calendars\Providers;

use Emtudo\Units\School\Calendars\Routes\Api;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Emtudo\Units\School\Calendars\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        $this->mapApiRoutes();
    }

    /**
     * API Routes.
     */
    protected function mapApiRoutes()
    {
        (new Api([
            'middleware' => ['api', 'auth', 'admin'],
            'namespace' => $this->namespace,
            'prefix' => 'school/calendars',
            'as' => 'school_calendars::',
        ]))->register();
    }
}
