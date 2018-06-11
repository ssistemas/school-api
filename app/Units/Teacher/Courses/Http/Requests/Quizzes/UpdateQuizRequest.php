<?php

namespace Emtudo\Units\Teacher\Courses\Http\Requests\Quizzes;

use Emtudo\Support\Http\Request;
use Emtudo\Domains\Courses\Quiz;

class UpdateQuizRequest extends Request
{
    public function rules()
    {
        return Quiz::rules()->updating();
    }
}
