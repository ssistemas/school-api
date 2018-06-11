<?php

namespace Emtudo\Domains\Calendars\Transformers;

use Emtudo\Domains\Calendars\Event;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class EventTransformer extends Transformer
{
    /**
     * @param Event $event
     *
     * @return array
     */
    public function transform(Event $event)
    {
        return [
            'id' => $event->publicId(),
            'tenant_id' => encode_id($event->tenant_id),

            'label' => $event->label,
            'date' => $event->getValue('date'),
            'description' => $event->description ?? null,
            'address' => $event->address ?? null,
        ];
    }
}
