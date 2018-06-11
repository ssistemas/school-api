<?php

namespace Emtudo\Domains\Courses\Events;

use Emtudo\Domains\Courses\Frequency;
use Illuminate\Queue\SerializesModels;

class FrequencyCreating
{
    public function __construct(Frequency $frequency)
    {
        if ($frequency->present) {
            $frequency->justified_absence = false
        }
    }
}
