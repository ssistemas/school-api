<?php

namespace Emtudo\Domains\Calendars\Transformers;

use Emtudo\Domains\Calendars\SchoolDay;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class SchoolDayTransformer extends Transformer
{
    /**
     * @param SchoolDay $schoolDay
     *
     * @return array
     */
    public function transform(SchoolDay $schoolDay)
    {
        return [
            'id' => $schoolDay->publicId(),
            'date' => $schoolDay->getValue('date'),
            'label' => $schoolDay->description ?? null,
            'school_day' => (bool) (int) $schoolDay->school_day,
        ];
    }
}
