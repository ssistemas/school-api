<?php

namespace Emtudo\Domains\Courses\Repositories;

use Emtudo\Domains\Courses\Contracts\CourseRepository as CourseRepositoryContract;
use Emtudo\Domains\Courses\Course;
use Emtudo\Domains\Courses\Queries\CourseQueryFilter;
use Emtudo\Domains\Courses\Transformers\CourseTransformer;
use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Support\Domain\Repositories\TenantRepository;

class CourseRepository extends TenantRepository implements CourseRepositoryContract
{
    /**
     * @var string
     */
    protected $modelClass = Course::class;

    /**
     * @var string
     */
    protected $transformerClass = CourseTransformer::class;

    /**
     * Retrieve items based on informed parameters.
     *
     * @param array $params
     * @param int   $take
     * @param bool  $paginate
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\AbstractPaginator
     */
    public function getAllCoursesByParams(array $params, $take = 15, $paginate = true)
    {
        $query = (new CourseQueryFilter($this->newQuery(), $params))->getQuery();

        return $this->doQuery($query, $take, $paginate);
    }

    public function createStandardCoursesByTenant(Tenant $tenant)
    {
        $courses = [
            'Primeira série',
            'Segunda série',
            'Terceira série',
            'Quarta série',
            'Quinta série',
            'Sexta série',
            'Sétima série',
            'Oitava série',
            'Nona série',
        ];

        array_map(function ($course) use ($tenant) {
            factory(Course::class)->create([
                'tenant_id' => $tenant->id,
                'label' => $course,
            ]);
        }, $courses);
    }
}
