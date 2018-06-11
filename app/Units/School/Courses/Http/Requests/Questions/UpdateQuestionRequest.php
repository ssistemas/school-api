<?php

namespace Emtudo\Units\School\Courses\Http\Requests\Questions;

use Emtudo\Support\Http\Request;
use Emtudo\Domains\Courses\Question;

class UpdateQuestionRequest extends Request
{
    public function rules()
    {
        return Question::rules()->updating();
    }
}
