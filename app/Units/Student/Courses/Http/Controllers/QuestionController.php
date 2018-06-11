<?php

namespace Emtudo\Units\Student\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Contracts\QuestionRepository;
use Emtudo\Support\Http\Controller;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    protected $cleaningRules = [
        'id' => 'id',
    ];

    /**
     * @param QuestionRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, QuestionRepository $repository)
    {
        $questions = $repository->getAllQuestionsByParams($this->params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($questions, null, $this->includes);
    }

    /**
     * @param string             $id
     * @param QuestionRepository $repository
     */
    public function show($id, QuestionRepository $repository)
    {
        $question = $repository->findByPublicID($id);

        if (!$question) {
            return $this->respond->notFound('Pergunta não encontrada.');
        }

        return $this->respond->ok($question, null, $this->includes);
    }
}
