<?php

namespace Emtudo\Units\Responsible\Users\Http\Controllers;

use Emtudo\Domains\Courses\Responsibles\Contracts\GradeRepository;
use Emtudo\Domains\Courses\Responsibles\Contracts\GroupRepository;
use Emtudo\Domains\Users\Contracts\UserRepository;
use Emtudo\Support\Http\Controller;

class GradeController extends Controller
{
    public function getByGroup(string $studentId, string $groupId, GradeRepository $repository, GroupRepository $groupRepository, UserRepository $userRepository)
    {
        $student = $userRepository->findByPublicId($studentId);
        if (!$student) {
            return $this->respond->notFound('Estudante não encontrado');
        }
        $group = $groupRepository->findByPublicId($groupId);
        if (!$group) {
            return $this->respond->notFound('Turma não encontrada');
        }
        $grades = $repository->gradesFromStudentAndGroup($student, $group);

        return $this->respond->ok($grades);
    }
}
