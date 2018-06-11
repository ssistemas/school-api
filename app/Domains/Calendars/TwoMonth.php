<?php

namespace Emtudo\Domains\Calendars;

use Carbon\Carbon;
use Emtudo\Domains\Calendars\Resources\Rules\TwoMonthRules;
use Emtudo\Domains\Calendars\Transformers\TwoMonthTransformer;
use Emtudo\Domains\Model;
use Emtudo\Support\Shield\HasRules;

class TwoMonth extends Model
{
    use HasRules;

    protected $increments = false;

    /**
     * @var string
     */
    protected static $rulesFrom = TwoMonthRules::class;

    /**
     * @var string
     */
    protected $transformerClass = TwoMonthTransformer::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'start1',
        'end1',
        'start2',
        'end2',
        'start3',
        'end3',
        'start4',
        'end4',
    ];

    protected $dates = [
        'start1',
        'end1',
        'start2',
        'end2',
        'start3',
        'end3',
        'start4',
        'end4',
    ];

    public static function isSchoolDay(Carbon $date)
    {
        $year = $date->year;
        $newDate = $date->format('Y-m-d');
        if (!self::find($year)) {
            return true;
        }

        return self::where('id', $year)
            ->where(function ($query) use ($newDate) {
                $query
                    ->whereRaw("'{$newDate}' between start1 and end1")
                    ->orWhereRaw("'{$newDate}' between start2 and end2")
                    ->orWhereRaw("'{$newDate}' between start3 and end3")
                    ->orWhereRaw("'{$newDate}' between start4 and end4");
            })->exists();
    }

    public static function isHoliday(Carbon $date)
    {
        return !self::isSchoolDay($date);
    }

    public static function getTwoMonthByYear(int $year)
    {
        return self::where('id', $year)->first();
    }
}
