<?php

namespace Emtudo\Units;

use Illuminate\Foundation\Http\Kernel;

class HttpKernel extends Kernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \ResultSystems\Cors\CorsMiddleware::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Emtudo\Units\Core\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Emtudo\Units\Core\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Emtudo\Units\Core\Http\Middleware\Tenants\DetectTenant::class,
            \Emtudo\Units\Core\Http\Middleware\Tenants\NeedsInformation::class,
            \Emtudo\Units\Core\Http\Middleware\Tenants\NeedsActiveSubscription::class,
            \Emtudo\Units\Core\Http\Middleware\Tenants\PendingActivation::class,
            \Emtudo\Units\Core\Http\Middleware\TenantHeader::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
            \Emtudo\Units\Core\Http\Middleware\TenantHeader::class,
            \Emtudo\Units\Core\Http\Middleware\SlowMode::class,
            //\Illuminate\Session\Middleware\StartSession::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \Emtudo\Units\Core\Http\Middleware\RedirectIfAuthenticated::class,
        'no_cities' => \Emtudo\Units\Core\Http\Middleware\Tenants\UnBlockByCity::class,
        'admin' => \Emtudo\Units\Core\Http\Middleware\Admin::class,
        'responsible' => \Emtudo\Units\Core\Http\Middleware\Responsible::class,
        'responsible_of_student' => \Emtudo\Units\Core\Http\Middleware\ResponsibleOfStudent::class,
        'role' => \Emtudo\Units\Core\Http\Middleware\Role::class,
        'staff' => \Emtudo\Units\Core\Http\Middleware\StaffRole::class,
        'teacher' => \Emtudo\Units\Core\Http\Middleware\Teacher::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    ];
}
