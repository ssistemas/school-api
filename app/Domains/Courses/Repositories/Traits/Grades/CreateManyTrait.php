<?php

namespace Emtudo\Domains\Courses\Repositories\Traits\Grades;

trait CreateManyTrait
{
    public function createMany(array $data = [])
    {
        // 'quiz_id' => 'required|exists_public_id_by_tenant:quizzes,id',
        // 'student_id' => 'required|exists_public_id_by_tenant:users,id',
        // 'value' => 'required|integer|min:0|max:100',

        //  'quiz_id' => 'required|exists_public_id_by_tenant:quizzes,id',
        // 'students' => 'required|array',
        // 'students.*.student_id' => 'required|exists_public_id_by_tenant:users,id',
        // 'students.*.grade' => 'required|integer|min:0|max:100',

        $tenant = tenant();
        $timestamps = [
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        $newData = array_map(function ($student) use ($data, $tenant, $timestamps) {
            return array_merge([
                    'tenant_id' => $tenant->id,
                    'quiz_id' => $data['quiz_id'],
                    'student_id' => $student['student_id'],
                    'value' => $student['grade'],
                ], $timestamps);
        }, $data['students']);

        Grade::unguard();
        $grade = $this->newQuery()->getModel()->newInstance();

        $grades = $grade->insert($newData);

        Grade::reguard();

        return $grades;
    }
}
