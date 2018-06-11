<?php

namespace Emtudo\Domains\Calendars\Database\Factories;

use Emtudo\Domains\Calendars\Calendar;
use Emtudo\Support\Domain\Database\ModelFactory;

class CalendarFactory extends ModelFactory
{
    protected $model = Calendar::class;

    public function fields()
    {
        return [
        ];
    }
}
