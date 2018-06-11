<?php

namespace Emtudo\Domains\Transports;

use Emtudo\Domains\TenantModel;
use Emtudo\Domains\Transports\Resources\Rules\VehicleRules;
use Emtudo\Domains\Transports\Transformers\VehicleTransformer;
use Emtudo\Support\Shield\HasRules;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Vehicle.
 */
class Vehicle extends TenantModel
{
    use HasRules, SoftDeletes;

    /**
     * @var string
     */
    protected static $rulesFrom = VehicleRules::class;

    /**
     * @var string
     */
    protected $transformerClass = VehicleTransformer::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label',
        'board',
        'capacity',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function routes($driver = null, $operator = 'like')
    {
        return $this->belongsToMany(Route::class, 'vehicle_route')
            ->withTimestamps()
            ->withPivot('driver');
    }

    public function routesByDriver($driver = null, $operator = 'like')
    {
        return $this->belongsToMany(Route::class, 'vehicle_route')
            ->withTimestamps()
            ->withPivot('driver')
            ->wherePivot('driver', $operator, $driver);
    }

    public function routesByShift($shift)
    {
        $options = $shift;
        if (is_array($options)) {
            $options = [$shift];
        }

        return $this->belongsToMany(Route::class, 'vehicle_route')
            ->withTimestamps()
            ->withPivot('driver')
            ->wherePivotIn('shift', $options);
    }
}
