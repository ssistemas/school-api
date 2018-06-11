<?php

namespace Emtudo\Domains\Tenants\Database\Factories;

use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Support\Domain\Database\ModelFactory;
use Illuminate\Support\Str;

class TenantFactory extends ModelFactory
{
    protected $model = Tenant::class;

    public function fields()
    {
        $name = $this->faker->company;

        return [
            'name' => $name,
            'country_register' => $this->faker->cnpj(false),
            'label' => Str::words($name, 1, ''),
            'email' => $this->faker->email,
            // 'director_id' => factory(User::class)->create()->id,
            'active' => $this->faker->boolean(90),
            'phones' => [
                'other' => $this->faker->phoneNumberCleared(false),
                'work' => $this->faker->landlineNumber(false),
                'mobile' => $this->faker->cellphone(false),
            ],
            'address' => [
                'street' => $this->faker->streetName,
                'number' => $this->faker->buildingNumber,
                'complement' => null,
                'district' => $this->faker->randomElement([
                    'Xaxim',
                    'Boqueirão',
                    'Universitário',
                    'Uberaba',
                    'Centro',
                    'Boa Vista',
                    'Bairro Novo',
                    'Olinda',
                ]),
                'city' => $this->faker->city,
                'state' => $this->faker->stateAbbr,
                'zip' => str_replace('-', '', $this->faker->postcode),
            ],
        ];
    }
}
