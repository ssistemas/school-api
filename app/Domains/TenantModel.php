<?php

namespace Emtudo\Domains;

use Emtudo\Domains\Tenants\Tenant;

abstract class TenantModel extends Model
{
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
                    throw new \InvalidArgumentException(get_class($model).' need to be a valid tenant_id attribute');
                }
            }
        });
    }

    public function setOwnerTenant()
    {
        $tenant = Tenant::currentTenant();
        if ($tenant) {
            $this->tenant_id = $tenant->id;
        }
    }
}
