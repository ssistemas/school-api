<?php

namespace Emtudo\Domains\Calendars\Database\Factories;

use Emtudo\Domains\Calendars\Event;
use Emtudo\Support\Domain\Database\ModelFactory;

class EventFactory extends ModelFactory
{
    protected $model = Event::class;

    public function fields()
    {
        return [
        ];
    }
}
