<?php

namespace Emtudo\Domains;

abstract class PivotTenantUser extends Pivot
{
    /**
     * Validate the model, so you will always have a tenant_id.
     */
    public static function boot()
    {
        parent::boot();

        self::saving(function ($model) {
            if (empty($model->tenant_id)) {
                $model->setOwnerTenant();
                if (empty($model->tenant_id)) {
                    throw new \InvalidArgumentException(get_class($model) . ' need to be a valid tenant_id attribute');
                }
            }
            if (empty($model->user_id)) {
                $model->setOwnerUser();
                if (empty($model->user_id)) {
                    throw new \InvalidArgumentException(get_class($model) . ' need to be a valid user_id attribute');
                }
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function localTenant()
    {
        return $this->tenant();
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function setOwnerTenant()
    {
        $tenant = Tenant::currentTenant();
        if ($tenant) {
            $this->tenant_id = $tenant->id;
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function localUser()
    {
        return $this->user();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function setOwnerUser()
    {
        $user = auth()->user();
        if ($user) {
            $this->user_id = $user->id;
        }
    }
}
