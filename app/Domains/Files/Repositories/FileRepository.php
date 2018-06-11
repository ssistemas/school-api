<?php

namespace Emtudo\Domains\Files\Repositories;

use Emtudo\Domains\Files\Contracts\FileRepository as FileRepositoryContract;
use Emtudo\Domains\Files\File;
use Emtudo\Domains\Files\Queries\FileQueryFilter;
use Emtudo\Domains\Files\Repositories\Transformers\FileTransform;
use Emtudo\Support\Domain\Repositories\TenantRepository;
use Emtudo\Support\Helpers\UUID;
use Illuminate\Http\UploadedFile;

class FileRepository extends TenantRepository implements FileRepositoryContract
{
    protected $modelClass = File::class;

    /**
     * @var string
     */
    protected $transformerClass = FileTransform::class;

    public function findByUUID($uuid)
    {
        return $this->newQuery()->where('uuid', $uuid)->first();
    }

    public function lastFiles($take = 10)
    {
        $query = $this->newQuery()->orderBy('created_at', 'desc');

        return $this->doQuery($query, $take, false);
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
    public function getAllFilesByParams(array $params, $take = 15, $paginate = true)
    {
        $query = (new FileQueryFilter($this->newQuery(), $params))->getQuery()->orderBy('created_at', 'desc');

        return $this->doQuery($query, $take, $paginate);
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param null         $kind
     *
     * @return null|mixed
     */
    public function createTemporary(UploadedFile $uploadedFile, $kind = null)
    {
        if ($uploadedFile) {
            // crate a new File Model instance and set it's attributes
            /** @var File $file */
            $file = app()->make($this->modelClass);
            $file->label = $uploadedFile->getClientOriginalName();
            $file->uuid = UUID::v4();
            $file->mime = $uploadedFile->getClientMimeType();
            $file->size = $uploadedFile->getSize();
            $file->kind = $kind;
            $file->extension = $uploadedFile->getClientOriginalExtension();

            $saved = $this->save($file);

            // if the file was successfully saved
            if ($saved) {
                /** @var \Illuminate\Contracts\Filesystem\Filesystem $storage */
                $storage = File::getStorage();

                // put it on the right storage path.
                $storage->put($file->getRelativePath(), file_get_contents($uploadedFile));

                // return saved file id.
                return $file;
            }
        }

        // return null if the upload fails.
        return null;
    }
}
