<?php

namespace Emtudo\Domains\Calendars\Transformers;

use Emtudo\Domains\Calendars\Calendar;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class CalendarTransformer extends Transformer
{
    /**
     * @param Calendar $calendar
     *
     * @return array
     */
    public function transform($calendar)
    {
        return [
            'id' => $calendar->publicId(),
            'tenant_id' => encode_id($calendar->tenant_id),

            'year' => (int) $calendar->year,
            'label' => $calendar->label,
        ];
    }
}
