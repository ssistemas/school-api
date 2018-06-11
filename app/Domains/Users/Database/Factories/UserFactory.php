<?php

namespace Emtudo\Domains\Users\Database\Factories;

use Carbon\Carbon;
use Emtudo\Domains\Users\User;
use Emtudo\Support\Domain\Database\ModelFactory;

/**
 * Class UserFactory.
 */
class UserFactory extends ModelFactory
{
    /**
     * @var User Factory for the User Model
     */
    protected $model = User::class;

    /**
     * Define the User's Model Factory.
     */
    public function fields()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'country_register' => $this->faker->unique()->cpf(false),
            'birthdate' => Carbon::now()->subYears(rand(18, 45))->format('Y-m-d'),
            'password' => 'secret',
            'remember_token' => str_random(10),
            'state_register' => $this->faker->rg(false),
            'state_register_entity' => $this->faker->randomElement(['SSP', 'PM', 'PC', 'CNT', 'DIC', 'CTPS', 'FGTS', 'IFP', 'IPF', 'IML', 'MTE', 'MMA', 'MAE', 'MEX', 'POF', 'POM', 'SES', 'SJS', 'SJTS', 'ZZZ']),
            'state_register_state' => $this->faker->stateAbbr,
            'phones' => [
                'home' => $this->faker->landlineNumber(false),
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
