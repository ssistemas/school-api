<?php

namespace Emtudo\Units\Tenant\Http\Controllers;

use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Domains\Users\Transformers\AuthTransformer;
use Emtudo\Domains\Users\User;
use Emtudo\Support\Http\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(['auth']);
    }

    public function changeTenant(Request $request, Guard $auth)
    {
        $tenantId = decode_id($request->get('tenant_id'));

        /** @var User $user */
        $user = $this->user;

        if (!$user->belongsToTenant($tenantId)) {
            return $this->respond->invalid($user, 'Não foi possível trocar se escola');
        }
        $user->last_tenant = $tenantId;
        $user->save();
        Tenant::currentTenantByLoggedUser();
//            Tenant::setCurrentTenant(Tenant::find($tenantId));

        return $this->respond->ok($auth, null, ['user.tenant', 'user.tenants', 'user.profiles', 'user.have_profiles'], [], [], new AuthTransformer());
    }
}
