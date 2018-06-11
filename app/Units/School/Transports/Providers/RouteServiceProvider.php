<?php

namespace Emtudo\Units\School\Transports\Providers;

use Emtudo\Units\School\Transports\Routes\Api;
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
    protected $namespace = 'Emtudo\Units\School\Transports\Http\Controllers';

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
            'prefix' => 'school/transports',
            'as' => 'school_transports::',
        ]))->register();
    }
}
