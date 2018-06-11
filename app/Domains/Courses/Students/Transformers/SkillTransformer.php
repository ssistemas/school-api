<?php

namespace Emtudo\Domains\Courses\Students\Transformers;

use Emtudo\Domains\Courses\Skill;
use Emtudo\Domains\Users\Transformers\TeacherTransformer;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class SkillTransformer extends Transformer
{
    public $availableIncludes = [
        'subject',
        'teacher',
    ];

    /**
     * @param Skill $skill
     *
     * @return array
     */
    public function transform(Skill $skill)
    {
        return [
            'id' => $skill->publicId(),
            'label' => $skill->getLabel(),
            'teacher_id' => encode_id($skill->teacher_id),
            'subject_id' => encode_id($skill->subject_id),
        ];
    }

    public function includeSubject(Skill $skill)
    {
        $subject = $skill->subject;
        if (!$subject) {
            return;
        }

        return $this->item($subject, new SubjectTransformer());
    }

    public function includeTeacher(Skill $skill)
    {
        $teacher = $skill->teacher;
        if (!$teacher) {
            return;
        }

        return $this->item($teacher, new TeacherTransformer());
    }
}
