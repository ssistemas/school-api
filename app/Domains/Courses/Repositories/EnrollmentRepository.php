<?php

namespace Emtudo\Domains\Courses\Repositories;

use Emtudo\Domains\Courses\Contracts\EnrollmentRepository as EnrollmentRepositoryContract;
use Emtudo\Domains\Courses\Enrollment;
use Emtudo\Domains\Courses\Queries\EnrollmentQueryFilter;
use Emtudo\Domains\Courses\Transformers\EnrollmentTransformer;
use Emtudo\Support\Domain\Repositories\TenantRepository;

class EnrollmentRepository extends TenantRepository implements EnrollmentRepositoryContract
{
    /**
     * @var string
     */
    protected $modelClass = Enrollment::class;

    /**
     * @var string
     */
    protected $transformerClass = EnrollmentTransformer::class;

    public function create(array $data = [])
    {
        $enrollment = $this->newQuery()
            ->where('student_id', $data['student_id'])
            ->where('group_id', $data['group_id'])
            ->select('id')
            ->first();

        if ($enrollment) {
            $this->update($enrollment, $data);

            return $enrollment;
        }

        $model = parent::create($data);
        if (!$model) {
            return $model;
        }

        return $model;
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
    public function getAllEnrollmentsByParams(array $params, $take = 15, $paginate = true)
    {
        $query = (new EnrollmentQueryFilter($this->newEnrollmentQuery(), $params))->getQuery();

        return $this->doQuery($query, $take, $paginate);
    }

    /**
     * get new query on those who are transports.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    protected function newEnrollmentQuery()
    {
        return $this->newQuery();
    }
}
