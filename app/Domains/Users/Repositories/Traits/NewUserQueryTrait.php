<?php

namespace Emtudo\Domains\Users\Repositories\Traits;

trait NewUserQueryTrait
{
    /**
     * get new query on those who are tenants.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    protected function newUserQuery()
    {
        if ($this->adminsOnly) {
            return $this->getAdminUsers();
        }
        if ($this->managersOnly) {
            return $this->newQueryFilterUserByType('manager');
        }
        if ($this->responsiblesOnly) {
            return $this->getResponsibleUsers();
        }
        if ($this->studentsOnly) {
            return $this->getStudentUsers();
        }
        if ($this->teachersOnly) {
            return $this->getTeacherUsers();
        }

        return $this->newQuery();
    }

    protected function getAdminUsers()
    {
        return $this->newQuery()
                ->where('is_admin', true);
    }

    protected function getResponsibleUsers()
    {
        return $this->newQuery()
                ->where(function ($query) {
                    return $query->whereHas('tenants', function ($query) {
                        $query
                            ->select('tenants_users.tenant_id')
                            ->where('tenants_users.tenant_id', tenant()->id)
                            ->where('tenants_users.responsible', true);
                    })
                        ->orWhere(function ($query) {
                            return $query
                                ->whereNotNull('users.parent1_id')
                                ->orWhereNotNull('users.parent2_id')
                                ->orWhereNotNull('users.responsible1_id')
                                ->orWhereNotNull('users.responsible2_id');
                        });
                });
    }

    protected function getStudentUsers()
    {
        return $this->newQuery()
                ->where(function ($query) {
                    return $query->whereHas('tenants', function ($query) {
                        $query
                            ->select('tenants_users.tenant_id')
                            ->where('tenants_users.tenant_id', tenant()->id)
                            ->where('tenants_users.student', true);
                    })
                        ->orWhereHas('enrollments', function ($query) {
                            $query
                                ->select('enrollments.id')
                                ->where('enrollments.tenant_id', tenant()->id);
                        });
                });
    }

    protected function getTeacherUsers()
    {
        return $this->newQuery()
                ->where(function ($query) {
                    return $query->whereHas('tenants', function ($query) {
                        $query
                            ->select('tenants_users.tenant_id')
                            ->where('tenants_users.tenant_id', tenant()->id)
                            ->where('tenants_users.teacher', true);
                    })
                        ->orWhereHas('skills', function ($query) {
                            $query
                                ->select('subjects.id')
                                ->where('subjects.tenant_id', tenant()->id);
                        });
                });
    }
}
