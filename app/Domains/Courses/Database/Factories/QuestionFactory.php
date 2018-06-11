<?php

namespace Emtudo\Domains\Courses\Database\Factories;

use Emtudo\Domains\Courses\Question;
use Emtudo\Support\Domain\Database\ModelFactory;

class QuestionFactory extends ModelFactory
{
    protected $model = Question::class;

    public function fields()
    {
        return [
            // 'quiz_id' => factory(Quiz::class)->create()->id,

            'ask' => $this->faker->sentence(3),
            // 'options' => '',
            // 'answer' => '',
        ];
    }
}
