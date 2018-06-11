<?php

namespace Emtudo\Domains\Users\Transformers;

use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Domains\Tenants\Transformers\SimpleTenantTransformer;
use Emtudo\Domains\Users\User;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class UserTransformer extends Transformer
{
    public $availableIncludes = ['tenant', 'tenants', 'profiles', 'have_profiles'];

    public function transform(User $user)
    {
        return [
            'id' => $user->publicId(),

            'address' => $this->parseAddress($user->address ?? []),
            'avatar' => $user->getAvatarUrl(),
            'birthdate' => $user->getValue('birthdate'),
            'country_register' => $user->country_register,
            'deleted_at' => $user->getValue('deleted_at'),
            'documents' => $user->documents ?? [
                'address' => null,
                'country_register' => null,
                'state_register' => null,
            ],
            'email' => $user->email,
            'is_admin' => (bool) (int) $user->is_admin,
            'last_tenant' => encode_id($user->last_tenant),
            'master' => (bool) (int) $user->master,
            'name' => $user->name,
            'phones' => $user->phones ?? [
                'work' => null,
                'home' => null,
                'mobile' => null,
            ],
            'state_register' => $user->state_register,
            'state_register_state' => $user->state_register_state,
            'state_register_entity' => $user->state_register_entity,
        ];
    }

    public function includeProfiles(User $user)
    {
        $isManager = $user->isManager();
        $isResponsible = $user->isResponsible();
        $isStudent = $user->isStudent();
        $isTeacher = $user->isTeacher();

        return $this->primitive([
            'manager' => $isManager,
            'responsible' => $isResponsible,
            'student' => $isStudent,
            'teacher' => $isTeacher,
        ]);
    }

    public function includeHaveProfiles(User $user)
    {
        $isManager = $user->isManager();
        $isResponsible = $user->isResponsible();
        $isStudent = $user->isStudent();
        $isTeacher = $user->isTeacher();

        return $this->primitive([
            'manager' => $user->getProfile('manager') || $isManager,
            'responsible' => $user->getProfile('responsible') || $isResponsible,
            'student' => $user->getProfile('student') || $isStudent,
            'teacher' => $user->getProfile('teacher') || $isTeacher,
        ]);
    }

    public function includeTenant(User $user)
    {
        $currentTenant = Tenant::currentTenant();
        if (!$currentTenant) {
            return;
        }

        return $this->item($currentTenant, new SimpleTenantTransformer());
    }

    /**
     * @param $user
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeTenants(User $user)
    {
        if ($user->isAdmin()) {
            return $this->tenantsByAdmin();
        }

        $tenants = $user->tenants;

        // get current logged user.
        $loggedUser = auth()->user();

        if ($loggedUser && $loggedUser->id === $user->id) {
            $current = Tenant::currentTenant();
            $exists = $tenants->first(function ($tenant) use ($current) {
                return $tenant->id === $current->id;
            });
            if (!$exists) {
                $tenants->push($current);
            }
        }

        return $this->collection($tenants, new SimpleTenantTransformer());
    }

    protected function tenantsByAdmin()
    {
        return $this->collection(Tenant::all(), new SimpleTenantTransformer());
    }
}
