<?php

namespace Emtudo\Units\Student\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Contracts\QuizRepository;
use Emtudo\Support\Http\Controller;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    protected $cleaningRules = [
        'id' => 'id',
    ];

    /**
     * @param QuizRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, QuizRepository $repository)
    {
        $quizzes = $repository->with(['Schedule'])->getAllQuizzesByParams($this->params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($quizzes, null, $this->includes);
    }

    /**
     * @param string         $id
     * @param QuizRepository $repository
     */
    public function show($id, QuizRepository $repository)
    {
        $quiz = $repository->findByPublicID($id);

        if (!$quiz) {
            return $this->respond->notFound('Prova não encontrada.');
        }

        return $this->respond->ok($quiz, null, $this->includes);
    }
}
