<?php

namespace Emtudo\Domains\Courses\Database\Factories;

use Emtudo\Domains\Courses\Enrollment;
use Emtudo\Support\Domain\Database\ModelFactory;

class EnrollmentFactory extends ModelFactory
{
    protected $model = Enrollment::class;

    public function fields()
    {
        return [
        ];
    }
}
