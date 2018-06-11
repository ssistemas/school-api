<?php

namespace Emtudo\Domains\Tenants\Transformers;

use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class SimpleTenantTransformer extends Transformer
{
    /**
     * @param Tenant $tenant
     *
     * @return array
     */
    public function transform(Tenant $tenant)
    {
        $manager = ($tenant->pivot) ? (bool) (int) $tenant->pivot->manager : null;
        $responsible = ($tenant->pivot) ? (bool) (int) $tenant->pivot->responsible : null;
        $student = ($tenant->pivot) ? (bool) (int) $tenant->pivot->student : null;
        $teacher = ($tenant->pivot) ? (bool) (int) $tenant->pivot->teacher : null;

        return [
            'id' => $tenant->publicId(),
            'name' => $tenant->name,
            'label' => $tenant->label,
            'manager' => $manager,
            'responsible' => $responsible,
            'student' => $student,
            'teacher' => $teacher,
            'current' => (bool) (tenant()->id === $tenant->id),
        ];
    }
}
