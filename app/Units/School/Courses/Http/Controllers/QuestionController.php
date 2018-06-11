<?php

namespace Emtudo\Units\School\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Contracts\QuestionRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\School\Courses\Http\Requests\Questions\CreateCourseRequest;
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

    /**
     * @param CreateCourseRequest $request
     * @param QuestionRepository  $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateQuestionRequest $request, QuestionRepository $repository)
    {
        $data = $this->cleanFields($request->all());

        $question = $repository->create($data);

        return $this->respond->ok($question);
    }

    /**
     * @param string                $id
     * @param UpdateQuestionRequest $request
     * @param QuestionRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateQuestionRequest $request, QuestionRepository $repository)
    {
        $question = $repository->findByPublicID($id);

        if (!$question) {
            return $this->respond->notFound('Pergunta não encontrada.');
        }

        $data = $this->cleanFields($request->all());

        $repository->update($question, $data);

        return $this->respond->ok($question);
    }

    public function destroy($id, QuestionRepository $repository)
    {
        $question = $repository->findByPublicID($id);

        if (!$question) {
            return $this->respond->notFound('Pergunta não encontrada.');
        }

        $repository->delete($question);

        return $this->respond->ok($question);
    }
}
