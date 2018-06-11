<?php

namespace Emtudo\Domains\Tenants;

use Emtudo\Domains\PivotTenantUser;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantUser extends PivotTenantUser
{
    use SoftDeletes;

    public $table = 'tenants_users';

    protected $fillable = [
        'student',
        'parent',
        'teacher',
        'manager',
        'user',
        'role',
    ];

    protected $casts = [
        'student' => 'boolean',
        'parent' => 'boolean',
        'teacher' => 'boolean',
        'manager' => 'boolean',
        'user' => 'boolean',
        // 'roles' => 'json',
    ];
}
