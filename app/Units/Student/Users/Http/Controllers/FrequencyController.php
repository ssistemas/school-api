<?php

namespace Emtudo\Units\Student\Users\Http\Controllers;

use Emtudo\Domains\Courses\Students\Contracts\FrequencyRepository;
use Emtudo\Domains\Courses\Students\Contracts\GroupRepository;
use Emtudo\Domains\Users\Contracts\UserRepository;
use Emtudo\Support\Http\Controller;

class FrequencyController extends Controller
{
    public function getByGroup(string $studentId, string $groupId, int $month, FrequencyRepository $repository, GroupRepository $groupRepository, UserRepository $userRepository)
    {
        $student = $userRepository->findByPublicId($studentId);
        if (!$student) {
            return $this->respond->notFound('Estudante não encontrado');
        }
        $group = $groupRepository->findByPublicId($groupId);
        if (!$group) {
            return $this->respond->notFound('Turma não encontrada');
        }
        $frequencies = $repository->frequenciesFromStudentAndGroup($student, $group, $month);

        return $this->respond->ok($frequencies);
    }

    public function getByGroupFromMe(string $groupId, int $month, FrequencyRepository $repository, GroupRepository $groupRepository, UserRepository $userRepository)
    {
        $user = auth()->user();

        return $this->getByGroup($user->publicId(), $groupId, $month, $repository, $groupRepository, $userRepository);
    }
}
