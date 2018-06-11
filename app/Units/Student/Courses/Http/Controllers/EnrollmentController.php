<?php

namespace Emtudo\Units\Student\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Contracts\EnrollmentRepository;
use Emtudo\Support\Http\Controller;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    protected $cleaningRules = [
        'id' => 'id',
    ];

    /**
     * @param EnrollmentRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, EnrollmentRepository $repository)
    {
        $enrollments = $repository->getAllEnrollmentsByParams($this->params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($enrollments, null, $this->includes);
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
        return $this->respond->ok($enrollment, null, $this->includes);
    }
}
