<?php

namespace Emtudo\Units\Teacher\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Teachers\Contracts\SubjectRepository;
use Emtudo\Support\Http\Controller;
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
        $subjects = $repository->getAllSubjectsByParams($this->params, $this->itemsPerPage, $this->pagination);

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
}
