<?php

namespace Emtudo\Domains\Courses\Repositories;

use DB;
use Emtudo\Domains\Courses\Contracts\GroupRepository as GroupRepositoryContract;
use Emtudo\Domains\Courses\Group;
use Emtudo\Domains\Courses\Queries\GroupQueryFilter;
use Emtudo\Domains\Courses\Schedule;
use Emtudo\Domains\Courses\Transformers\GroupTransformer;
use Emtudo\Support\Domain\Repositories\TenantRepository;

class GroupRepository extends TenantRepository implements GroupRepositoryContract
{
    /**
     * @var string
     */
    protected $modelClass = Group::class;

    /**
     * @var string
     */
    protected $transformerClass = GroupTransformer::class;

    public function newQuery()
    {
        return parent::newQuery()->orderBy('label');
    }

    public function create(array $data = [])
    {
        $model = parent::create($data);
        if (!$model) {
            return $model;
        }

        $this->syncSubjects($model, $data['subjects'] ?? []);

        return $model;
    }

    public function update($model, array $data = [])
    {
        $updated = parent::update($model, $data);
        if (!$updated) {
            return $updated;
        }

        $this->syncSubjects($model, $data['subjects'] ?? []);

        return $updated;
    }

    public function syncSubjects(Group $group, array $subjects = [])
    {
        if (empty($subjects)) {
            return;
        }

        return $group->subjects()->sync($subjects);
    }

    public function syncSchedules(Group $group, array $schedules = [])
    {
        if (empty($schedules)) {
            return;
        }

        $tenant = tenant();

        $addSchedule = function ($schedule) use ($group, $tenant) {
            // $model = $group->schedules()->newQuery()->getModel()->newInstance();
            $model = new Schedule();
            $schedule['skill_id'] = $schedule[$schedule['day'].'_skill_id'];
            $model->fill($schedule);
            $model->tenant_id = $tenant->id;
            $model->group_id = $group->id;
            $model->save();
        };

        array_walk($schedules, function ($schedule, $index) use ($addSchedule) {
            $addSchedule(array_merge($schedule, [
                'index' => $index,
                'day' => 'monday',
            ]));
            $addSchedule(array_merge($schedule, [
                'index' => $index,
                'day' => 'tuesday',
            ]));
            $addSchedule(array_merge($schedule, [
                'index' => $index,
                'day' => 'wednesday',
            ]));
            $addSchedule(array_merge($schedule, [
                'index' => $index,
                'day' => 'thursday',
            ]));
            $addSchedule(array_merge($schedule, [
                'index' => $index,
                'day' => 'friday',
            ]));
        });
    }

    public function syncStudents(Group $group, array $students = [])
    {
        if (empty($students)) {
            return;
        }

        $tenantId = tenant()->id;

        return $group->students()->sync(array_map(function ($student) use ($tenantId) {
            $student['tenant_id'] = $tenantId;

            return $student;
        }, $students));
    }

    /**
     * Retrieve items based on informed parameters.
     *
     * @param array $params
     * @param int   $take
     * @param bool  $paginate
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\AbstractPaginator
     */
    public function getAllGroupsByParams(array $params, $take = 15, $paginate = true)
    {
        $query = (new GroupQueryFilter($this->newQuery(), $params))->getQuery();

        return $this->doQuery($query, $take, $paginate);
    }

    public function getAvailableVacancies(?int $year = null)
    {
        if (!$year) {
            $year = date('Y');
        }

        $tenantId = tenant()->id;

        return (int) DB::SELECT(
            "
            select sum(available) as available from (
                select (groups.max_students - count(enrollments.group_id)) as available from groups
                    LEFT JOIN enrollments ON enrollments.group_id = groups.id
                    WHERE groups.year = {$year}
                        and groups.tenant_id = {$tenantId}
                    GROUP by groups.id) as groups
            "
        )[0]->available ?? 0;
    }
}
