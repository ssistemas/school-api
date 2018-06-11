<?php

namespace Emtudo\Units\Student\Users\Http\Controllers;

use Emtudo\Domains\Courses\Students\Contracts\GradeRepository;
use Emtudo\Domains\Courses\Students\Contracts\GroupRepository;
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

    public function getByGroupFromMe(string $groupId, GradeRepository $repository, GroupRepository $groupRepository, UserRepository $userRepository)
    {
        $user = auth()->user();

        return $this->getByGroup($user->publicId(), $groupId, $repository, $groupRepository, $userRepository);
    }
}
