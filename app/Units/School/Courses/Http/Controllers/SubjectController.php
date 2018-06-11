<?php

namespace Emtudo\Units\School\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Contracts\SubjectRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\School\Courses\Http\Requests\Subjects\CreateSubjectRequest;
use Emtudo\Units\School\Courses\Http\Requests\Subjects\UpdateSubjectRequest;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    protected $cleaningRules = [
        'id' => 'id',
        'teachers' => [
            'teacher_id' => 'id',
        ],
    ];

    /**
     * @param SubjectRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, SubjectRepository $repository)
    {
        $params = $this->cleanFields($request->all());
        $subjects = $repository->getAllSubjectsByParams($params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($subjects, null, $this->includes);
    }

    /**
     * @param string            $id
     * @param SubjectRepository $repository
     */
    public function show($id, SubjectRepository $repository)
    {
        $subject = $repository->findByPublicID($id);

        if (!$subject) {
            return $this->respond->notFound('Disciplina não encontrada.');
        }

        return $this->respond->ok($subject, null, $this->includes);
    }

    /**
     * @param CreateSubjectRequest $request
     * @param SubjectRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateSubjectRequest $request, SubjectRepository $repository)
    {
        $data = $this->cleanFields($request->all());

        $subject = $repository->create($data);

        return $this->respond->ok($subject);
    }

    /**
     * @param string               $id
     * @param UpdateSubjectRequest $request
     * @param SubjectRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateSubjectRequest $request, SubjectRepository $repository)
    {
        $subject = $repository->findByPublicID($id);

        if (!$subject) {
            return $this->respond->notFound('Disciplina não encontrada.');
        }

        $data = $this->cleanFields($request->all());

        $repository->update($subject, $data);

        return $this->respond->ok($subject);
    }

    public function destroy($id, SubjectRepository $repository)
    {
        $subject = $repository->findByPublicID($id);

        if (!$subject) {
            return $this->respond->notFound('Disciplina não encontrada.');
        }

        $repository->delete($subject);

        return $this->respond->ok($subject);
    }
}
