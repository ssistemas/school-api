<?php

namespace Emtudo\Units\Search\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Contracts\EnrollmentRepository;
use Emtudo\Support\Http\Controller;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * @param EnrollmentRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, EnrollmentRepository $repository)
    {
        $params = $request->all();
        $enrollments = $repository->getAllEnrollmentsByParams($params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($enrollments);
    }

    /**
     * @param string               $id
     * @param EnrollmentRepository $repository
     */
    public function show($id, EnrollmentRepository $repository)
    {
        $enrollment = $repository->findByPublicID($id);

        if (!$enrollment) {
            return $this->respond->notFound('Matrícula não encontrada.');
        }

        // if not found...
        return $this->respond->ok($enrollment);
    }
}
