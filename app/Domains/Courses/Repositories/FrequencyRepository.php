<?php

namespace Emtudo\Domains\Courses\Repositories;

use DB;
use Emtudo\Domains\Calendars\SchoolDay;
use Emtudo\Domains\Calendars\TwoMonth;
use Emtudo\Domains\Courses\Contracts\FrequencyRepository as FrequencyRepositoryContract;
use Emtudo\Domains\Courses\Frequency;
use Emtudo\Domains\Courses\Queries\FrequencyQueryFilter;
use Emtudo\Domains\Courses\Subject;
use Emtudo\Domains\Courses\Transformers\FrequencyTransformer;
use Emtudo\Support\Domain\Repositories\TenantRepository;

class FrequencyRepository extends TenantRepository implements FrequencyRepositoryContract
{
    use Traits\Frequencies\Students;
    protected $updateAtOrder = true;

    /**
     * @var string
     */
    protected $modelClass = Frequency::class;

    /**
     * @var string
     */
    protected $transformerClass = FrequencyTransformer::class;

    /**
     * Retrieve items based on informed parameters.
     *
     * @param array $params
     * @param int   $take
     * @param bool  $paginate
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\AbstractPaginator
     */
    public function getAllFrequenciesByParams(array $params, $take = 15, $paginate = true)
    {
        $query = (new FrequencyQueryFilter($this->newQuery(), $params))->getQuery();

        return $this->doQuery($query, $take, $paginate);
    }

    public function createMany(array $data = [])
    {
        // 'schedule_id' => 'required|exists_public_id_by_tenant:schedules,id',
        // 'date' => 'bail|required|date|date_format:Y-m-d|exists_school_day:school_days,date',
        // 'students' => 'required|array',
        // 'students.*.student_id' => 'required|exists_public_id:users,id',
        // 'students.*.present' => 'required|boolean',
        // 'students.*.justified_absence' => 'nullable|sometimes|boolean',

        $tenant = tenant();
        $timestamps = [
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        DB::beginTransaction();

        try {
            $newData = array_map(function ($student) use ($data, $tenant, $timestamps) {
                $schoolDayId = SchoolDay::where('date', $data['date'])->first()->id;
                $subjectId = Subject::whereHas('skills.schedules', function ($query) use ($data) {
                    $query->where('id', $data['schedule_id']);
                })->first()->id;
                $frequency = $this->newQuery()
                    ->where('schedule_id', $data['schedule_id'])
                    ->where('school_day_id', $schoolDayId)
                    ->where('student_id', $student['student_id'])
                    ->first();

                $justifiedAbsence = (!$student['present']) ? $student['justified_absence'] : false;

                if ($frequency) {
                    $frequency->present = $student['present'];
                    $frequency->justified_absence = $justifiedAbsence;
                    $frequency->save();

                    return false;
                }

                return array_merge([
                    'id' => uuid(),
                    'tenant_id' => $tenant->id,
                    'schedule_id' => $data['schedule_id'],
                    'subject_id' => $subjectId,
                    'school_day_id' => $schoolDayId,
                    'student_id' => $student['student_id'],
                    'present' => $student['present'],
                    'justified_absence' => $justifiedAbsence,
                ], $timestamps);
            }, $data['students']);

            Frequency::unguard();
            $frequency = $this->newQuery()->getModel()->newInstance();

            $insert = array_filter($newData);

            if (!empty($newData)) {
                $frequencies = $frequency->insert($insert);
            }

            Frequency::reguard();
            DB::commit();

            return $frequencies;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception('Não foi possível cadastrar a company');
        }
    }

    public function newQuery()
    {
        $query = parent::newQuery();
        if ($this->updateAtOrder) {
            $query->orderBy('updated_at', 'DESC');
        }

        return $query;
    }

    public function getFrequenciesByYear(int $year)
    {
        $presents = [];
        $absences = [];
        $january = $this->getFrequenciesByYearMonth((int) "{$year}01");
        $february = $this->getFrequenciesByYearMonth((int) "{$year}02");
        $march = $this->getFrequenciesByYearMonth((int) "{$year}03");
        $april = $this->getFrequenciesByYearMonth((int) "{$year}04");
        $may = $this->getFrequenciesByYearMonth((int) "{$year}05");
        $june = $this->getFrequenciesByYearMonth((int) "{$year}06");
        $july = $this->getFrequenciesByYearMonth((int) "{$year}07");
        $august = $this->getFrequenciesByYearMonth((int) "{$year}08");
        $september = $this->getFrequenciesByYearMonth((int) "{$year}09");
        $october = $this->getFrequenciesByYearMonth((int) "{$year}10");
        $november = $this->getFrequenciesByYearMonth((int) "{$year}11");
        $december = $this->getFrequenciesByYearMonth((int) "{$year}12");

        $presents[] = (int) $january->presents;
        $presents[] = (int) $february->presents;
        $presents[] = (int) $march->presents;
        $presents[] = (int) $april->presents;
        $presents[] = (int) $may->presents;
        $presents[] = (int) $june->presents;
        $presents[] = (int) $july->presents;
        $presents[] = (int) $august->presents;
        $presents[] = (int) $september->presents;
        $presents[] = (int) $october->presents;
        $presents[] = (int) $november->presents;
        $presents[] = (int) $december->presents;

        $absences[] = (int) $january->absences;
        $absences[] = (int) $february->absences;
        $absences[] = (int) $march->absences;
        $absences[] = (int) $april->absences;
        $absences[] = (int) $may->absences;
        $absences[] = (int) $june->absences;
        $absences[] = (int) $july->absences;
        $absences[] = (int) $august->absences;
        $absences[] = (int) $september->absences;
        $absences[] = (int) $october->absences;
        $absences[] = (int) $november->absences;
        $absences[] = (int) $december->absences;

        return [
            'presents' => $presents,
            'absences' => $absences,
        ];
    }

    public function getFrequenciesByYearMonth(int $yearMonth)
    {
        return DB::select("SELECT IFNULL(SUM(present), 0) AS presents, IFNULL(SUM(if(present=0, 1, 0)), 0) as absences  FROM frequencies
            WHERE school_day_id IN (
                SELECT id FROM school_days
                WHERE school_days.id = frequencies.school_day_id
                    AND DATE_FORMAT(date, '%Y%m') = {$yearMonth}
                )")[0];
    }

    public function getTopAbsences(int $year, ?int $twoMonth = null, $take = 5, $paginate = false)
    {
        $this->updateAtOrder = false;
        $query = $this->newQuery();
        $query->whereHas('schoolDay', function ($query) use ($year, $twoMonth) {
            $query
                        ->select('id')
                        ->whereRaw('YEAR(`school_days`.`date`) = ?', $year);
            if ($twoMonth and $twoMonth > 0 and $twoMonth < 5) {
                $dates = TwoMonth::getTwoMonthByYear($year);
                $start = "start{$twoMonth}";
                $end = "end{$twoMonth}";
                $first = $dates->$start;
                $second = $dates->$end;
                $query->whereBetween('school_days.date', [$first, $second]);
            }
        })
                ->selectRaw('SUM(if(`frequencies`.`present`=0, 1, 0)) as absences')
                ->addSelect('student_id')
                ->groupBy('frequencies.student_id')
                ->orderBy('absences', 'DESC')
                ->with(['student']);

        return $this->doQuery($query, $take, $paginate);
    }
}
