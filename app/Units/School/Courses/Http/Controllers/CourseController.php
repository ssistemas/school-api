<?php

namespace Emtudo\Units\School\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Contracts\CourseRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\School\Courses\Http\Requests\Courses\CreateCourseRequest;
use Emtudo\Units\School\Courses\Http\Requests\Courses\UpdateCourseRequest;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected $cleaningRules = [
        'id' => 'id',
    ];

    /**
     * @param CourseRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, CourseRepository $repository)
    {
        $params = $this->cleanFields($request->all());
        $courses = $repository->getAllCoursesByParams($params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($courses);
    }

    /**
     * @param string           $id
     * @param CourseRepository $repository
     */
    public function show($id, CourseRepository $repository)
    {
        $course = $repository->findByPublicID($id);

        if (!$course) {
            return $this->respond->notFound('Curso não encontrado.');
        }

        return $this->respond->ok($course);
    }

    /**
     * @param CreateCourseRequest $request
     * @param CourseRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateCourseRequest $request, CourseRepository $repository)
    {
        $data = $this->cleanFields($request->all());

        $course = $repository->create($data);

        return $this->respond->ok($course);
    }

    /**
     * @param string              $id
     * @param UpdateCourseRequest $request
     * @param CourseRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateCourseRequest $request, CourseRepository $repository)
    {
        $course = $repository->findByPublicID($id);

        if (!$course) {
            return $this->respond->notFound('Curso não encontrado.');
        }

        $data = $this->cleanFields($request->all());

        $repository->update($course, $data);

        return $this->respond->ok($course);
    }

    public function destroy($id, CourseRepository $repository)
    {
        $course = $repository->findByPublicID($id);

        if (!$course) {
            return $this->respond->notFound('Curso não encontrado.');
        }

        $repository->delete($course);

        return $this->respond->ok($course);
    }
}
