<?php

namespace Emtudo\Domains\Calendars;

use Emtudo\Domains\Calendars\Resources\Rules\SchoolDayRules;
use Emtudo\Domains\Calendars\Transformers\SchoolDayTransformer;
use Emtudo\Domains\Model;
use Emtudo\Support\Shield\HasRules;

class SchoolDay extends Model
{
    use HasRules;

    /**
     * @var string
     */
    protected static $rulesFrom = SchoolDayRules::class;

    /**
     * @var string
     */
    protected $transformerClass = SchoolDayTransformer::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'label',
    ];

    protected $dates = [
        'date',
    ];
}
