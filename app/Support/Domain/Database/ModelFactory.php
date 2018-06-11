<?php

namespace Emtudo\Support\Domain\Database;

use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;

/**
 * Class ModelFactory.
 *
 * Base Factory for usage inside domains.
 */
abstract class ModelFactory
{
    /**
     * @var Factory
     */
    protected $factory;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * BaseFactory constructor.
     */
    public function __construct()
    {
        $this->factory = app()->make(Factory::class);
        $faker = app()->make(Generator::class);
        $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));
        $faker->addProvider(new \Faker\Provider\pt_BR\Address($faker));
        $faker->addProvider(new \Faker\Provider\pt_BR\PhoneNumber($faker));
        $faker->addProvider(new \Faker\Provider\pt_BR\Company($faker));
        $faker->addProvider(new \Faker\Provider\Lorem($faker));
        $faker->addProvider(new \Faker\Provider\Internet($faker));

        $this->faker = $faker;
    }

    /**
     * @return mixed
     */
    public function define()
    {
        $this->factory->define($this->model, function () {
            return $this->fields();
        });
    }

    /**
     * @return mixed
     */
    abstract public function fields();
}
