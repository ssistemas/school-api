<?php

namespace Emtudo\Units\Tenant\Routes;

use Emtudo\Support\Http\Routing\RouteFile;

/**
 * Tenant Api Routes.
 */
class Api extends RouteFile
{
    /**
     * Declare API Routes.
     */
    public function routes()
    {
        // tenant information route.
        $this->router
            ->get('notifications/last', 'NotificationController@last')
            ->name('notifications.last');

        // change tenant route.
        $this->router
            ->post('change', 'TenantController@changeTenant')
            ->name('change_tenant');
    }
}
