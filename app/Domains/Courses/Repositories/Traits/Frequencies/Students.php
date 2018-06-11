<?php

namespace Emtudo\Domains\Courses\Repositories\Traits\Frequencies;

use DB;
use Emtudo\Domains\Courses\Group;
use Emtudo\Domains\Users\User;

trait Students
{
    public function frequenciesFromStudentAndGroup(User $student, Group $group, int $month = 1)
    {
        DB::SELECT('set session sql_mode="STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION";');

        DB::SELECT('SET @SQL = NULL;');

        DB::SELECT("SELECT GROUP_CONCAT(DISTINCT CONCAT('
(CASE(
SELECT frequencies.present FROM frequencies AS aux
WHERE aux.id = frequencies.id
AND aux.subject_id = frequencies.subject_id
AND aux.subject_id = ', subjects.id, '
AND aux.present = 1
AND aux.school_day_id = school_days.id
)
WHEN frequencies.subject_id = subjects.id THEN ''Presente''
ELSE (CASE frequencies.justified_absence = 1 WHEN 1 THEN ''Falta Justificada''
    ELSE (CASE school_days.school_day = 1 WHEN 1 THEN ''Ausente'' ELSE NULL END) END
) END)
'
, ' AS ''', subjects.label, ''''))
INTO @SQL FROM `frequencies`

INNER JOIN subjects ON subjects.id = frequencies.subject_id
INNER JOIN schedules ON schedules.id = frequencies.schedule_id
INNER JOIN groups ON groups.id = schedules.group_id
WHERE frequencies.school_day_id IN (
SELECT school_days.id FROM school_days
WHERE
    MONTH(school_days.date) = {$month}
    AND YEAR(school_days.date) = {$group->year}
    AND groups.id = {$group->id}
    AND frequencies.student_id = {$student->id}
 ORDER BY subjects.label);");
        $prepare = DB::SELECT('SELECT @SQL AS query_sql')[0];
        if (!$prepare->query_sql) {
            return;
        }

        $sql = "SELECT DAY(school_days.date) AS day, school_days.school_day, {$prepare->query_sql} FROM school_days
        LEFT JOIN frequencies ON frequencies.school_day_id = school_days.id AND frequencies.student_id = {$student->id}

        LEFT JOIN subjects ON subjects.id = frequencies.subject_id
        WHERE
            MONTH(school_days.date) = {$month}
            AND YEAR(school_days.date) = {$group->year}
        ORDER BY day;";

        return DB::SELECT($sql);
    }
}

/*SET @SQL = NULL;

SELECT GROUP_CONCAT(DISTINCT CONCAT('
(CASE(
SELECT frequencies.present FROM frequencies AS aux
WHERE aux.id = frequencies.id
AND aux.subject_id = frequencies.subject_id
AND aux.subject_id = ', subjects.id, '
AND aux.present = 1
) WHEN frequencies.subject_id = subjects.id THEN 1 ELSE 0 END)
'
, ' AS ''', subjects.label, ''''))
INTO @SQL FROM `frequencies`

INNER JOIN subjects ON subjects.id = frequencies.subject_id
WHERE frequencies.school_day_id IN (
SELECT school_days.id FROM school_days
WHERE
MONTH(school_days.date) = 1
AND YEAR(school_days.date) = 2018
);

SET @SQL = CONCAT('SELECT DAY(school_days.date) AS day, school_days.school_day, ', @SQL, ' FROM `school_days`
INNER JOIN frequencies ON frequencies.school_day_id = school_days.id AND frequencies.student_id = 1
INNER JOIN subjects ON subjects.id = frequencies.subject_id
WHERE
MONTH(school_days.date) = 1
AND YEAR(school_days.date) = 2018
ORDER BY day;');

SELECT @SQL;

PREPARE stmt FROM @SQL;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

 */
