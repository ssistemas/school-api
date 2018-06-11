<?php

namespace Emtudo\Domains\Courses\Transformers;

use Emtudo\Domains\Courses\Question;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class QuestionTransformer extends Transformer
{
    /**
     * @param Question $question
     *
     * @return array
     */
    public function transform(Question $question)
    {
        return [
            'id' => $question->publicId(),
            'quiz_id' => encode_id($question->quiz_id),

            'ask' => $question->ask,
            'options' => $question->options,
            'answer' => $question->answer,
        ];
    }
}
