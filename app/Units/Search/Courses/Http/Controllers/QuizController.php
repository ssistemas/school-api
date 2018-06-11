<?php

namespace Emtudo\Units\Search\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Contracts\QuizRepository;
use Emtudo\Support\Http\Controller;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * @param QuizRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, QuizRepository $repository)
    {
        $params = $request->all();
        $quizzes = $repository->getAllQuizzesByParams($params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($quizzes);
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

        return $this->respond->ok($quiz, null, ['skill']);
    }
}
