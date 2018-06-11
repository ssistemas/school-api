<?php

namespace Emtudo\Domains\Users;

use Emtudo\Domains\Pivot;

class UserTenantPivot extends Pivot
{
    protected $fillable = [
        'user_id',
        'tenant_id',
        'student',
        'manager',
        'teacher',
        'responsible',
    ];
}
