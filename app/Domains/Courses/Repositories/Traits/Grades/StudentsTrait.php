<?php

namespace Emtudo\Domains\Courses\Repositories\Traits\Grades;

use Carbon\Carbon;
use DB;
use Emtudo\Domains\Calendars\TwoMonth;
use Emtudo\Domains\Courses\Group;
use Emtudo\Domains\Users\User;

trait StudentsTrait
{
    public function gradesFromStudentAndGroup(User $student, Group $group)
    {
        $twoMonth = TwoMonth::find($group->year);
        if (!$twoMonth) {
            return [];
        }

        return [
            'first' => $this->gradesFromStudentAndGroupAndDates($student, $group, $twoMonth->start1, $twoMonth->end1),
            'second' => $this->gradesFromStudentAndGroupAndDates($student, $group, $twoMonth->start2, $twoMonth->end2),
            'third' => $this->gradesFromStudentAndGroupAndDates($student, $group, $twoMonth->start3, $twoMonth->end3),
            'fourth' => $this->gradesFromStudentAndGroupAndDates($student, $group, $twoMonth->start4, $twoMonth->end4),
        ];
    }

    public function gradesFromStudentAndGroupAndDates(User $student, Group $group, Carbon $dateStart, Carbon $dateEnd)
    {
        DB::SELECT('set session sql_mode="STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION";');
        $query = app()->make($this->modelClass)->newQuery();
        $query->selectRaw('SUM(grades.value) AS grade,
                subjects.id AS subject_id,
                subjects.label AS subject,
                IFNULL((SELECT SUM(1) FROM frequencies
                    WHERE frequencies.subject_id = subjects.id AND
                        frequencies.student_id = grades.student_id AND
                        frequencies.present=1), 0) as present,
                IFNULL((SELECT SUM(1) FROM frequencies
                    WHERE frequencies.subject_id = subjects.id AND
                        frequencies.student_id = grades.student_id AND
                        frequencies.present=0), 0) AS absence,
                IFNULL((SELECT SUM(1) FROM frequencies
                    WHERE frequencies.subject_id = subjects.id AND
                        frequencies.student_id = grades.student_id AND
                        frequencies.justified_absence=1), 0) AS justified_absence');

        $query->join('quizzes', 'quizzes.id', '=', 'grades.quiz_id');
        $query->join('schedules', 'schedules.id', '=', 'quizzes.schedule_id');
        $query->join('skills', 'skills.id', '=', 'schedules.skill_id');
        $query->join('subjects', 'subjects.id', '=', 'skills.subject_id');
        $query->join('groups', 'groups.id', '=', 'schedules.group_id');
        $query->join('enrollments', function ($join) {
            $join->on('enrollments.group_id', '=', 'groups.id')
                ->whereColumn('enrollments.student_id', 'grades.student_id');
        });
        $query->where('grades.student_id', $student->id);
        $query->whereBetween('quizzes.date', [$dateStart, $dateEnd]);
        $query->where('groups.id', $group->id);
        $query->groupBy('subjects.id', 'subjects.label');

        return $this->doQuery($query, false, false);
    }
}
