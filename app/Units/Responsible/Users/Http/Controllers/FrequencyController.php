<?php

namespace Emtudo\Units\Responsible\Users\Http\Controllers;

use Emtudo\Domains\Courses\Responsibles\Contracts\FrequencyRepository;
use Emtudo\Domains\Courses\Responsibles\Contracts\GroupRepository;
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
}
