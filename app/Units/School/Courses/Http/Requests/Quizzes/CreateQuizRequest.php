<?php

namespace Emtudo\Units\School\Courses\Http\Requests\Quizzes;

use Emtudo\Support\Http\Request;
use Emtudo\Domains\Courses\Quiz;

class CreateQuizRequest extends Request
{
    public function rules()
    {
        return Quiz::rules()->creating();
    }
}
