<?php

namespace Emtudo\Units\School\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Contracts\QuizRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\School\Courses\Http\Requests\Quizzes\CreateQuizRequest;
use Emtudo\Units\School\Courses\Http\Requests\Quizzes\UpdateQuizRequest;
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

    /**
     * @param CreateQuizRequest $request
     * @param QuizRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateQuizRequest $request, QuizRepository $repository)
    {
        $data = $this->cleanFields($request->all());

        $quiz = $repository->create($data);

        return $this->respond->ok($quiz);
    }

    /**
     * @param string            $id
     * @param UpdateQuizRequest $request
     * @param QuizRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateQuizRequest $request, QuizRepository $repository)
    {
        $quiz = $repository->findByPublicID($id);

        if (!$quiz) {
            return $this->respond->notFound('Prova não encontrada.');
        }

        $data = $this->cleanFields($request->all());

        $repository->update($quiz, $data);

        return $this->respond->ok($quiz);
    }

    public function destroy($id, QuizRepository $repository)
    {
        $quiz = $repository->findByPublicID($id);

        if (!$quiz) {
            return $this->respond->notFound('Prova não encontrada.');
        }

        $repository->delete($quiz);

        return $this->respond->ok($quiz);
    }
}
