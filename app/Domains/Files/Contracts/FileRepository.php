<?php

namespace Emtudo\Domains\Files\Contracts;

use Emtudo\Support\Domain\Repositories\Contracts\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

interface FileRepository extends Repository
{
    /**
     * @param string $uuid
     *
     * @return null|\Emtudo\Domains\Files\File
     */
    public function findByUUID($uuid);

    /**
     * @param int $take
     *
     * @return Collection
     */
    public function lastFiles($take = 10);

    /**
     * Retrieve items based on informed parameters.
     *
     * @param array $params
     * @param int   $take
     * @param bool  $paginate
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\AbstractPaginator
     */
    public function getAllFilesByParams(array $params, $take = 15, $paginate = true);

    /**
     * @param UploadedFile $uploadedFile
     * @param null         $kind
     *
     * @return mixed
     */
    public function createTemporary(UploadedFile $uploadedFile, $kind = null);
}
