<?php

namespace Emtudo\Domains\Transports;

use Emtudo\Domains\TenantModel;
use Emtudo\Domains\Transports\Resources\Rules\StopRules;
use Emtudo\Domains\Transports\Transformers\StopTransformer;
use Emtudo\Support\Shield\HasRules;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Stop.
 */
class Stop extends TenantModel
{
    use HasRules, SoftDeletes;

    /**
     * @var string
     */
    protected static $rulesFrom = StopRules::class;

    /**
     * @var string
     */
    protected $transformerClass = StopTransformer::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label',
        'address',
    ];

    protected $casts = [
        'address' => 'json',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function routes()
    {
        return $this->belongsToMany(Route::class)
            ->withTimestamps();
    }
}
