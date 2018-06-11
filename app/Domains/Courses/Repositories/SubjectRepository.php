<?php

namespace Emtudo\Domains\Courses\Repositories;

use Emtudo\Domains\Courses\Contracts\SubjectRepository as SubjectRepositoryContract;
use Emtudo\Domains\Courses\Queries\SubjectQueryFilter;
use Emtudo\Domains\Courses\Subject;
use Emtudo\Domains\Courses\Transformers\SubjectTransformer;
use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Support\Domain\Repositories\TenantRepository;

class SubjectRepository extends TenantRepository implements SubjectRepositoryContract
{
    /**
     * @var string
     */
    protected $modelClass = Subject::class;

    /**
     * @var string
     */
    protected $transformerClass = SubjectTransformer::class;

    public function create(array $data = [])
    {
        $subject = parent::create($data);
        if (!$subject) {
            return $subject;
        }

        $this->syncTeachers($subject, $data['teachers'] ?? []);

        return $subject;
    }

    public function update($model, array $data = [])
    {
        $subject = parent::update($model, $data);
        if (!$subject) {
            return $subject;
        }

        $this->syncTeachers($model, $data['teachers'] ?? []);

        return $subject;
    }

    public function syncTeachers(Subject $subject, array $teachers)
    {
        $tenantId = tenant()->id;

        return $subject->teachers()->sync(array_map(function ($teacher) use ($tenantId) {
            $teacher['tenant_id'] = $tenantId;

            return $teacher;
        }, $teachers));
    }

    /**
     * Retrieve items based on informed parameters.
     *
     * @param array $params
     * @param int   $take
     * @param bool  $paginate
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\AbstractPaginator
     */
    public function getAllSubjectsByParams(array $params, $take = 15, $paginate = true)
    {
        $query = (new SubjectQueryFilter($this->newQuery(), $params))->getQuery();

        return $this->doQuery($query, $take, $paginate);
    }

    public function createStandardSubjectsByTenant(Tenant $tenant)
    {
        $subjects = [
            'Artes',
            'Biologia',
            'Ciências',
            'Disciplina',
            'Educação Física',
            'Espanhol',
            'Geografia',
            'História',
            'Inglês',
            'Libras',
            'Literatura',
            'Matemática',
            'Português',
            'Psicologia',
            'Química',
            'Sociologia',
        ];

        array_map(function ($subject) use ($tenant) {
            factory(Subject::class)->create([
                'tenant_id' => $tenant->id,
                'label' => $subject,
            ]);
        }, $subjects);
    }
}
