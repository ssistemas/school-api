<?php

namespace Emtudo\Units\School\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Contracts\EnrollmentRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\School\Courses\Http\Requests\Enrollments\CreateEnrollmentRequest;
use Emtudo\Units\School\Courses\Http\Requests\Enrollments\UpdateEnrollmentRequest;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    protected $cleaningRules = [
        'id' => 'id',
        'group_id' => 'id',
        'route_id' => 'id',
        'student_id' => 'id',
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

    /**
     * @param CreateEnrollmentRequest $request
     * @param EnrollmentRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateEnrollmentRequest $request, EnrollmentRepository $repository)
    {
        $data = $this->cleanFields($request->all());

        $enrollment = $repository->create($data);

        if (!$enrollment) {
            return $this->respond->error('Houve uma falha ao cadastrar');
        }

        return $this->respond->ok($enrollment);
    }

    /**
     * @param string                  $id
     * @param UpdateEnrollmentRequest $request
     * @param EnrollmentRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateEnrollmentRequest $request, EnrollmentRepository $repository)
    {
        $enrollment = $repository->findByPublicID($id);

        if (!$enrollment) {
            return $this->respond->notFound('Matrícula não encontrada.');
        }

        $data = $this->cleanFields($request->all());

        $repository->update($enrollment, $data);

        return $this->respond->ok($enrollment);
    }

    public function destroy($id, EnrollmentRepository $repository)
    {
        $enrollment = $repository->findByPublicID($id);

        if (!$enrollment) {
            return $this->respond->notFound('Matrícula não encontrada.');
        }

        $repository->delete($enrollment);

        return $this->respond->ok($enrollment);
    }
}
