<?php

namespace Emtudo\Units\Tenant\Http\Controllers;

use Carbon\Carbon;
use Emtudo\Support\Http\Controller;
use Illuminate\Http\JsonResponse;

/**
 * Class TenantController.
 */
class NotificationController extends Controller
{
    /**
     * Number of notifications to display the user.
     *
     * @var int
     */
    protected $notificationsLimit = 15;

    /**
     * Returns the current Tenant last notifications.
     *
     * @return JsonResponse
     */
    public function last()
    {
        // get the last 10 notifications for the user.
        $notifications = $this->getLastNotifications();
        // when the notifications was retrieved.
        $meta = ['when' => Carbon::now()->format('Y-m-d H:i:s'), 'tenant' => tenant_public_id()];
        // return a default transformer notification.
        return $this->respond->ok($notifications, '', [], $meta);
    }

    /**
     * Get the last notifications for the tenant.
     *
     * @return JsonResponse
     */
    protected function getLastNotifications()
    {
        return tenant()->notifications()->limit($this->notificationsLimit)->get();
    }
}
