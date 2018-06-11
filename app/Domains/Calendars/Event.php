<?php

namespace Emtudo\Domains\Calendars;

use Emtudo\Domains\Calendars\Resources\Rules\EventRules;
use Emtudo\Domains\Calendars\Transformers\EventTransformer;
use Emtudo\Domains\TenantModel;
use Emtudo\Support\Shield\HasRules;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * Class Event.
 */
class Event extends TenantModel
{
    use HasRules, Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected static $rulesFrom = EventRules::class;

    /**
     * @var string
     */
    protected $transformerClass = EventTransformer::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label',
        'date',
        'description',
        'address',
    ];

    protected $dates = [
    ];

    protected $casts = [
    ];
}
