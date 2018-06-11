<?php

namespace Emtudo\Domains\Calendars\Repositories;

use Emtudo\Domains\Calendars\Contracts\SchoolDayRepository as SchoolDayRepositoryContract;
use Emtudo\Domains\Calendars\Queries\SchoolDayQueryFilter;
use Emtudo\Domains\Calendars\SchoolDay;
use Emtudo\Domains\Calendars\Transformers\SchoolDayTransformer;
use Emtudo\Domains\Calendars\TwoMonth;
use Emtudo\Support\Domain\Repositories\Repository;

class SchoolDayRepository extends Repository implements SchoolDayRepositoryContract
{
    /**
     * @var string
     */
    protected $modelClass = SchoolDay::class;

    /**
     * @var string
     */
    protected $transformerClass = SchoolDayTransformer::class;

    public function newQuery()
    {
        return parent::newQuery()->orderBy('date');
    }

    /**
     * Retrieve items based on informed parameters.
     *
     * @param array $params
     * @param int   $take
     * @param bool  $paginate
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\AbstractPaginator
     */
    public function getAllSchoolDaysByParams(array $params, $take = 15, $paginate = true)
    {
        $query = (new SchoolDayQueryFilter($this->newQuery(), $params))->getQuery();

        return $this->doQuery($query, $take, $paginate);
    }

    public function getFromDate($date)
    {
        $query = $this->newQuery()
            ->where('date', $date);

        return $query->first();
    }

    public function getHolidaysInCurrentYear()
    {
        $year = (int) date('Y');
        if ($year < 2018) {
            $year = 2018;
        }

        return $this->getHolidaysFromYear($year);
    }

    public function getHolidaysFromYear(int $year)
    {
        if ($year < 2018) {
            $year = 2018;
        }

        $query = $this->newQuery()
            ->whereYear('date', $year)
            ->where('school_day', false);

        return $query->get();
    }

    public function toggle(SchoolDay $schoolDay)
    {
        $schoolDay->label = null;
        $schoolDay->school_day = !((bool) $schoolDay->school_day);
        if ($schoolDay->school_day && TwoMonth::isHoliday($schoolDay->date)) {
            $schoolDay->school_day = 0;
            $schoolDay->label = 'Férias Docentes';
        }

        return $schoolDay->save();
    }
}
