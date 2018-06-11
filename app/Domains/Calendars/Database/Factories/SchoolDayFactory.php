<?php

namespace Emtudo\Domains\Calendars\Database\Factories;

use Emtudo\Domains\Calendars\SchoolDay;
use Emtudo\Support\Domain\Database\ModelFactory;

class SchoolDayFactory extends ModelFactory
{
    protected $model = SchoolDay::class;

    public function fields()
    {
        return [
            'date' => $this->faker->date('Y-m-d'),
        ];
    }
}
