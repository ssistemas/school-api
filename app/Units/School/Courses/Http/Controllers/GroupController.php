<?php

namespace Emtudo\Units\School\Courses\Http\Controllers;

use Emtudo\Domains\Courses\Contracts\GroupRepository;
use Emtudo\Support\Http\Controller;
use Emtudo\Units\School\Courses\Http\Requests\Groups\CreateGroupRequest;
use Emtudo\Units\School\Courses\Http\Requests\Groups\UpdateGroupRequest;
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

    /**
     * @param CreateGroupRequest $request
     * @param GroupRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateGroupRequest $request, GroupRepository $repository)
    {
        $group = $repository->create($this->params);
        $repository->syncStudents($group, $this->params['students'] ?? []);
        $repository->syncSchedules($group, $this->params['schedules'] ?? []);

        return $this->respond->ok($group);
    }

    /**
     * @param string             $id
     * @param UpdateGroupRequest $request
     * @param GroupRepository    $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateGroupRequest $request, GroupRepository $repository)
    {
        $group = $repository->findByPublicID($id);

        if (!$group) {
            return $this->respond->notFound('Turma não encontrada.');
        }

        $repository->update($group, $this->params);
        $repository->syncSchedules($group, $this->params['schedules'] ?? []);

        return $this->respond->ok($group);
    }

    public function destroy($id, GroupRepository $repository)
    {
        $group = $repository->findByPublicID($id);

        if (!$group) {
            return $this->respond->notFound('Turma não encontrada.');
        }

        $repository->delete($group);

        return $this->respond->ok($group);
    }
}
