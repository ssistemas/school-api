<?php

namespace Emtudo\Domains\Transports;

use Emtudo\Domains\TenantModel;
use Emtudo\Domains\Transports\Resources\Rules\RouteRules;
use Emtudo\Domains\Transports\Transformers\RouteTransformer;
use Emtudo\Support\Shield\HasRules;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Route.
 */
class Route extends TenantModel
{
    use HasRules, SoftDeletes;

    /**
     * @var string
     */
    protected static $rulesFrom = RouteRules::class;

    /**
     * @var string
     */
    protected $transformerClass = RouteTransformer::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function stops()
    {
        return $this->belongsToMany(Stop::class, 'route_stop')
            ->withTimestamps();
    }
}
