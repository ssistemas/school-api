<?php

namespace Emtudo\Units\Search\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Contracts\SubjectRepository;
use Emtudo\Support\Http\Controller;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * @param SubjectRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, SubjectRepository $repository)
    {
        $params = $request->all();
        $subjects = $repository->getAllSubjectsByParams($params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($subjects);
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

        return $this->respond->ok($subject, null, ['teachers']);
    }
}
