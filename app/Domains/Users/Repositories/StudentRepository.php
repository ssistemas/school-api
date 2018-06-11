<?php

namespace Emtudo\Domains\Users\Repositories;

use Emtudo\Domains\Courses\Enrollment;
use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Domains\Users\Contracts\StudentRepository as Contract;
use Emtudo\Domains\Users\Student;

class StudentRepository extends UserRepository implements Contract
{
    protected $modelClass = Student::class;

    protected $studentsOnly = true;
    protected $adminsOnly = false;
    protected $managersOnly = false;
    protected $responsiblesOnly = false;
    protected $teachersOnly = false;

    public function create(array $data = [])
    {
        $user = parent::create($data);

        if (!$user) {
            return $user;
        }

        $user->tenants()->attach(Tenant::currentTenant(), ['student' => true]);

        return $user;
    }

    public function getAllStudentsByParams(array $params, $take = 15, $paginate = true)
    {
        return $this->filtersByParams($params, $take, $paginate);
    }

    public function delete($model, $force = false)
    {
        return $model->tenants()->updateExistingPivot(tenant()->id, ['student' => false]);
    }

    public function setProfileByEnrollment($student, Enrollment $enrollment)
    {
        return $student->tenants()->updateExistingPivot($enrollment->tenant_id, ['student' => true]);
    }
}
