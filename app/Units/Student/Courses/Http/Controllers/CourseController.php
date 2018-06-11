<?php

namespace Emtudo\Units\Student\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Contracts\CourseRepository;
use Emtudo\Support\Http\Controller;
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
}
