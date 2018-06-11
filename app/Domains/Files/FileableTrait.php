<?php

namespace Emtudo\Domains\Files;

use Emtudo\Domains\Files\Contracts\FileRepository;
use Emtudo\Support\Helpers\UUID;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Trait FileableTrait.
 *
 * Trait for usage among models that may own files on the
 * system.
 */
trait FileableTrait
{
    /**
     * Files Relationship.
     *
     * @param null|mixed $kind
     *
     * @return mixed
     */
    public function files($kind = null)
    {
        if ($kind) {
            return $this->morphMany(File::class, 'fileable')->where('kind', $kind);
        }

        return $this->morphMany(File::class, 'fileable');
    }

    /**
     * Attach a File to the current Entity.
     *
     * @param UploadedFile $uploadedFile Instance of the file being Uploaded
     * @param null|mixed   $tenantId
     * @param null|mixed   $kind
     *
     * @return bool
     */
    public function attachFile(UploadedFile $uploadedFile, $tenantId = null, $kind = null)
    {
        // Filesystem instance
        $storage = app('filesystem');

        // Check if the entity should have only a single
        // file attached
        if (isset($this->singleFile) && $this->singleFile) {
            // case true, delete the previous ones
            // before saving a new one.
            $files = $this->files($kind)->get();
            foreach ($files as $file) {
                $file->delete();
            }
        }

        // if the there is a uploaded file.
        if ($uploadedFile) {
            // crate a new File Model instance and set it's attributes
            $file = new File();
            $file->label = $uploadedFile->getClientOriginalName();
            $file->uuid = UUID::v4();
            $file->mime = $uploadedFile->getClientMimeType();
            $file->size = $uploadedFile->getSize();
            $file->kind = $kind;
            $file->extension = $uploadedFile->getClientOriginalExtension();

            // if tenant id is being overwrite
            if ($tenantId) {
                $file->tenant_id = $tenantId;
            }

            // @var File
            $savedFile = $this->files()->save($file);

            // if the file was successfully saved
            if ($savedFile->id) {
                // put it on the right storage path.
                $storage->put($savedFile->getRelativePath(), file_get_contents($uploadedFile));

                return true;
            }
        }

        return false;
    }

    /**
     * Attach a File by using it's UUID.
     *
     * @param string $uuid UUID of the file being uploaded
     *
     * @return bool|File
     */
    public function attachUUID(string $uuid)
    {
        /** @var FileRepository $repository */
        $repository = app()->make(FileRepository::class);

        /** @var File $file */
        $file = $repository->findByUUID($uuid);
        // if there is a file found.
        if ($file) {
            // Get file kind.
            //$kind = $file->kind;

            $file->fileable_id = $this->id;
            $file->fileable_type = self::class;
            $file->save();

            return $file;
        }

        return false;
    }

    /**
     * Get the entity's first attached file.
     *
     * @param null|mixed $kind
     *
     * @return null|File
     */
    public function firstFile($kind = null)
    {
        if ($kind) {
            return $this->files->where('kind', $kind)->sortByDesc('created_at')->first();
        }

        return $this->files->sortBy('created_at')->first();
    }
}
