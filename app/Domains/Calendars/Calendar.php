<?php

namespace Emtudo\Domains\Calendars;

use Emtudo\Domains\Calendars\Resources\Rules\CalendarRules;
use Emtudo\Domains\Calendars\Transformers\CalendarTransformer;
use Emtudo\Domains\TenantModel;
use Emtudo\Support\Shield\HasRules;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * Class Calendar.
 */
class Calendar extends TenantModel
{
    use HasRules,
    Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected static $rulesFrom = CalendarRules::class;

    /**
     * @var string
     */
    protected $transformerClass = CalendarTransformer::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'year',
        'label',
    ];

    protected $dates = [
    ];

    protected $casts = [
    ];
}
