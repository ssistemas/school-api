<?php

namespace Emtudo\Units\Teacher\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Teachers\Contracts\GroupRepository;
use Emtudo\Support\Http\Controller;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    protected $cleaningRules = [
        'id' => 'id',
        'course_id' => 'id',
        'schedules' => [
            'skill_id' => 'id',
            'monday_skill_id' => 'id',
            'tuesday_skill_id' => 'id',
            'wednesday_skill_id' => 'id',
            'thursday_skill_id' => 'id',
            'friday_skill_id' => 'id',
        ],
        'students' => [
            'student_id' => 'id',
            'route_id' => 'id',
        ],
    ];

    /**
     * @param GroupRepository $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, GroupRepository $repository)
    {
        $groups = $repository->getAllGroupsByParams($this->params, $this->itemsPerPage, $this->pagination);

        return $this->respond->ok($groups, null, $this->includes);
    }

    /**
     * @param string          $id
     * @param GroupRepository $repository
     */
    public function show($id, GroupRepository $repository)
    {
        $group = $repository->findByPublicID($id);

        if (!$group) {
            return $this->respond->notFound('Turma não encontrada.');
        }

        return $this->respond->ok($group, null, $this->includes);
    }
}
