<?php

namespace Emtudo\Domains\Users\Responsibles\Repositories;

use Emtudo\Domains\Users\Repositories\StudentRepository as Repository;
use Emtudo\Domains\Users\Responsibles\Contracts\StudentRepository as Contract;

class StudentRepository extends Repository implements Contract
{
    protected $studentsOnly = false;

    public function newQuery()
    {
        $query = parent::newQuery();
        $query
            ->where(function ($query) {
                $userId = auth()->user()->id;

                $query
                    ->where('users.parent1_id', $userId)
                    ->orWhere('users.parent2_id', $userId)
                    ->orWhere('users.responsible1_id', $userId)
                    ->orWhere('users.responsible2_id', $userId);
            });

        return $query;
    }
}
