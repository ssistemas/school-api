<?php

namespace Emtudo\Domains\Courses\Transformers;

use Emtudo\Domains\Courses\Enrollment;
use Emtudo\Domains\Transports\Transformers\RouteTransformer;
use Emtudo\Domains\Users\Transformers\StudentNameTransformer;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class EnrollmentTransformer extends Transformer
{
    public $availableIncludes = [
        'group',
        'student',
        'route',
    ];

    /**
     * @param Enrollment $enrollment
     *
     * @return array
     */
    public function transform(Enrollment $enrollment)
    {
        return [
            'id' => $enrollment->publicId(),
            'tenant_id' => encode_id($enrollment->tenant_id),
            'group_id' => encode_id($enrollment->group_id),
            'student_id' => encode_id($enrollment->student_id),
            'route_id' => encode_id($enrollment->route_id),
        ];
    }

    public function includeGroup(Enrollment $enrollment)
    {
        $group = $enrollment->group;
        if (!$group) {
            return;
        }

        return $this->item($group, new GroupTransformer());
    }

    public function includeStudent(Enrollment $enrollment)
    {
        $student = $enrollment->student;
        if (!$student) {
            return;
        }

        return $this->item($student, new StudentNameTransformer());
    }

    public function includeRoute(Enrollment $enrollment)
    {
        $route = $enrollment->route;
        if (!$route) {
            return;
        }

        return $this->item($route, new RouteTransformer());
    }
}
