<?php

namespace Emtudo\Domains\Courses\Database\Factories;

use Emtudo\Domains\Courses\Subject;
use Emtudo\Support\Domain\Database\ModelFactory;

class SubjectFactory extends ModelFactory
{
    protected $model = Subject::class;

    public function fields()
    {
        return [
            'label' => $this->faker->firstName,
        ];
    }
}
