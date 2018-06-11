<?php

namespace Emtudo\Domains\Courses\Database\Factories;

use Emtudo\Domains\Courses\Course;
use Emtudo\Support\Domain\Database\ModelFactory;

class CourseFactory extends ModelFactory
{
    protected $model = Course::class;

    public function fields()
    {
        return [
            'label' => $this->faker->firstName,
            'min_frequency' => 70,
            'min_grade' => 60,
        ];
    }
}
