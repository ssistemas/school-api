<?php

namespace Emtudo\Domains\Calendars\Database\Seeders;

use Carbon\Carbon;
use Emtudo\Domains\Calendars\SchoolDay;
use Emtudo\Domains\Calendars\TwoMonth;
use Illuminate\Database\Seeder;

class SchoolDaySeeder extends Seeder
{
    public function run()
    {
    }

    public static function createSchoolDays()
    {
        $holidays = require_once __DIR__.'/holidays.php';
        $date = Carbon::create(2018, 01, 01, 0);

        while ('2079-01-01' !== $date->format('Y-m-d')) {
            $current = $date->format('Y-m-d');
            $holiday = array_get($holidays, $current);
            if (!$holiday) {
                $holiday = TwoMonth::isHoliday($date) ? 'Férias Docentes' : null;
            }
            $data = [
                'date' => $current,
            ];

            if ($date->isWeekend()) {
                $data['school_day'] = false;
            }
            if ($holiday) {
                $data['school_day'] = false;
                $data['label'] = $holiday;
            }

            factory(SchoolDay::class)->create($data);
            $date->addDay();
        }
    }
}
