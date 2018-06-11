<?php

namespace Emtudo\Domains\Users\Repositories\Traits;

trait OnlyTrait
{
    public function adminsOnly($value = true)
    {
        $this->admins = $value;

        return $this;
    }

    public function schoolOnly($value = true)
    {
        $this->schoolOnly = $value;

        return $this;
    }

    public function managersOnly($value = true)
    {
        $this->managersOnly = $value;

        return $this;
    }

    public function responsiblesOnly($value = true)
    {
        $this->responsiblesOnly = $value;

        return $this;
    }

    public function studentsOnly($value = true)
    {
        $this->studentsOnly = $value;

        return $this;
    }

    public function teachersOnly($value = true)
    {
        $this->teachersOnly = $value;

        return $this;
    }
}
