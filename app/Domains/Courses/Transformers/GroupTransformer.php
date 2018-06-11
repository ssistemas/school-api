<?php

namespace Emtudo\Domains\Courses\Transformers;

use Emtudo\Domains\Courses\Group;
use Emtudo\Domains\Users\Transformers\UserLabelTransformer;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class GroupTransformer extends Transformer
{
    public $availableIncludes = [
        'course',
        'subjects',
        'schedules',
        'students',
        'quizzes',
        'skills',
        'my_skills',
        'force_my_skills',
        'my_schedules',
    ];

    /**
     * @param Group $group
     *
     * @return array
     */
    public function transform(Group $group)
    {
        return [
            'id' => $group->publicId(),
            'complete_label' => $group->course->label.' - '.$group->label.'/'.$group->year,
            'course_id' => encode_id($group->course_id),

            'label' => $group->label,
            'year' => (int) $group->year,

            'max_students' => (int) $group->max_students,
            'available_vacancies' => $group->getAvailabelVacancies(),
            // 'pass_score' => $group->pass_score ? (int) $group->pass_score : null,
            // 'period' => (int) $group->period,
        ];
    }

    public function includeCourse(Group $group)
    {
        $course = $group->course;

        if (!$course) {
            return;
        }

        return $this->item($course, new CourseTransformer());
    }

    public function includeSubjects(Group $group)
    {
        $subjects = $group->subjects;

        if (!$subjects) {
            return;
        }

        return $this->collection($subjects, new SubjectTransformer());
    }

    public function includeSchedules(Group $group)
    {
        $schedules = $group->schedules;

        if (!$schedules) {
            return;
        }

        return $this->collection($schedules, new ScheduleTransformer());
    }

    public function includeMySchedules(Group $group)
    {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return $this->includeSchedules($group);
        }

        return $this->includeForceMySchedules($group, $user->id);
    }

    public function includeForceMySchedules(Group $group, $userId = null)
    {
        $schedules = $group->schedulesFromUser($userId);
        if (!$schedules) {
            return;
        }

        return $this->collection($schedules, new ScheduleTransformer());
    }

    public function includeQuizzes(Group $group)
    {
        $quizzes = $group->getQuizzes();

        if (!$quizzes) {
            return;
        }

        return $this->collection($quizzes, new QuizTransformer());
    }

    public function includeSkills(Group $group)
    {
        $skills = $group->skills;
        if ($skills->isEmpty()) {
            return;
        }

        return $this->collection($skills, new SkillTransformer());
    }

    public function includeMySkills(Group $group)
    {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return $this->includeSkills($group);
        }

        return $this->includeForceMySkills($group, $user->id);
    }

    public function includeForceMySkills(Group $group, $userId = null)
    {
        $skills = $group->skillsFromUser($userId);
        if ($skills->isEmpty()) {
            return;
        }

        return $this->collection($skills, new SkillTransformer());
    }

    public function includeStudents(Group $group)
    {
        $students = $group->students;
        if ($students->isEmpty()) {
            return;
        }

        return $this->collection($students, new UserLabelTransformer());
    }
}
