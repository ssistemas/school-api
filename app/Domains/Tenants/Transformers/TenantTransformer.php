<?php

namespace Emtudo\Domains\Tenants\Transformers;

use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Domains\Users\Transformers\DirectorTransformer;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class TenantTransformer extends Transformer
{
    public $availableIncludes = [
        'director',
    ];

    /**
     * @param Tenant $tenant
     *
     * @return array
     */
    public function transform(Tenant $tenant)
    {
        return [
            'id' => $tenant->publicId(),
            'director_id' => encode_id($tenant->director_id),
            'name' => $tenant->name,
            'label' => $tenant->label,
            'country_register' => $tenant->country_register,
            'state_register' => $tenant->state_register,
            'city_register' => $tenant->city_register,
            'email' => $tenant->email,
            'address' => $this->parseAddress($tenant->address ?? []),
            'phones' => [
                'work' => $tenant->phones['work'] ?? null,
                'mobile' => $tenant->phones['mobile'] ?? null,
            ],
            'active' => (bool) (int) $tenant->active,
            'current' => (bool) (tenant()->id === $tenant->id),
            'director' => [
                'id' => null,
                'name' => null,
            ],
        ];
    }

    public function includeDirector(Tenant $tenant)
    {
        $director = $tenant->director;
        if (!$director) {
            return;
        }

        return $this->item($director, new DirectorTransformer());
    }
}
