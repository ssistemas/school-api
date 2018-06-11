<?php

namespace Emtudo\Domains\Courses\Teachers\Transformers;

use Emtudo\Domains\Courses\Frequency;
use Emtudo\Domains\Users\Transformers\StudentNameTransformer;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class FrequencyTransformer extends Transformer
{
    public $availableIncludes = [
        'subject',
        'student',
        'schedule',
    ];

    /**
     * @param Frequency $frequency
     *
     * @return array
     */
    public function transform(Frequency $frequency)
    {
        return [
            'id' => $frequency->getValue('id'),
            'schedule_id' => encode_id($frequency->schedule_id),

            'school_day_id' => encode_id($frequency->school_day_id),
            'date' => $frequency->schoolDay->getValue('date') ?? null,
            'student_id' => encode_id($frequency->student_id),

            'present' => (bool) (int) $frequency->present,
            'justified_absence' => (bool) (int) $frequency->justified_absence,
        ];
    }

    public function includeSchedule(Frequency $frequency)
    {
        $schedule = $frequency->schedule;

        if (!$schedule) {
            return;
        }

        return $this->item($schedule, new ScheduleTransformer());
    }

    public function includeStudent(Frequency $frequency)
    {
        $student = $frequency->student;

        if (!$student) {
            return;
        }

        return $this->item($student, new StudentNameTransformer());
    }

    public function includeSubject(Frequency $frequency)
    {
        $subject = $frequency->subject;

        if (!$subject) {
            return;
        }

        return $this->item($subject, new SubjectTransformer());
    }
}
