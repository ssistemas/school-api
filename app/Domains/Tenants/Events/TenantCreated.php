<?php

namespace Emtudo\Domains\Tenants\Events;

use Emtudo\Domains\Courses\Tenant;
use Illuminate\Queue\SerializesModels;

class TenantCreated
{
    use SerializesModels;

    /**
     * @var Tenant
     */
    public $tenant;

    public function __construct($tenant)
    {
        $this->tenant = $tenant;
    }
}
