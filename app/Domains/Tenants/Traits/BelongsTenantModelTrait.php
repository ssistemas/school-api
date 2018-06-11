<?php

namespace Emtudo\Domains\Tenants\Traits;

use Emtudo\Domains\Tenants\Tenant;

trait BelongsTenantModelTrait
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
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function setOwnerTenant()
    {
        $tenant = Tenant::currentTenant();
        if ($tenant) {
            $this->tenant_id = $tenant->id;
        }
    }
}
