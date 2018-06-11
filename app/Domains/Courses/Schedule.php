<?php

namespace Emtudo\Domains\Courses;

use Emtudo\Domains\Courses\Resources\Rules\ScheduleRules;
use Emtudo\Domains\Courses\Transformers\ScheduleTransformer;
use Emtudo\Domains\TenantModel;
use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Domains\Users\Teacher;
use Emtudo\Support\Shield\HasRules;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * Class Schedule.
 */
class Schedule extends TenantModel
{
    use HasRules, Notifiable, SoftDeletes;
    protected $increments = false;

    /**
     * @var string
     */
    protected static $rulesFrom = ScheduleRules::class;

    /**
     * @var string
     */
    protected $transformerClass = ScheduleTransformer::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id',
        'skill_id',
        'day',
        'index',
        'hour_start',
        'hour_end',
    ];

    public static function boot()
    {
        static::creating(function ($model) {
            $model->id = uuid();
        });
    }

    public function tenant()
    {
        return $this->hasOneThroughSeveral([
            Tenant::class,
            Course::class,
            Group::class,
        ]);
    }

    public function course()
    {
        return $this->hasOneThroughSeveral([
            Course::class,
            Group::class,
        ]);
    }

    public function frequencies()
    {
        return $this->hasMany(Frequencies::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function teacher()
    {
        return $this->hasOneThroughSeveral([
            Teacher::class,
            Skill::class,
        ]);
    }

    public function subject()
    {
        return $this->hasOneThroughSeveral([
            Subject::class,
            Skill::class,
        ]);
    }

    public function getLabel()
    {
        $day = translate_day($this->day);
        $start = substr($this->hour_start, 0, 5);
        $end = substr($this->hour_end, 0, 5);

        if (!$this->skill) {
            return ucfirst($day).' das '.$start.' às '.$end;
        }

        return ucfirst($day).' das '.$start.' às '.$end.' - '.$this->skill->getLabel();
    }
}
