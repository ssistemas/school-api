<?php

namespace Emtudo\Domains\Courses\Teachers\Transformers;

use Emtudo\Domains\Courses\Enrollment;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class EnrollmetTransformer extends Transformer
{
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
            'user_id' => encode_id($enrollment->user_id),

            'groupable_id' => encode_id($enrollment->groupable_id),
            'groupable_type' => $enrollment->groupable_type,
        ];
    }
}
