<?php

namespace Emtudo\Domains\Files\Transformers;

use Emtudo\Domains\Files\File;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class FileTransformer extends Transformer
{
    /**
     * @param File $file
     *
     * @return array
     */
    public function transform($file)
    {
        return [
            'id' => $file->publicId(),
            'uuid' => $file->uuid,
            'mime' => $file->mime,
            'size' => $file->size,
            'date' => $file->created_at->format('d/m/Y'),
            'extension' => $file->extension,
            'fileable_id' => $file->fileable_id,
            'fileable_label' => $file->fileable ? $file->fileable->selfLabel() : null,
            'fileable_type' => $file->fileable_type,
            'label' => $file->label,
            'short_label' => $file->shortLabel(),
            'kind' => $file->kind,
            'url' => $file->getSignedURL(),
        ];
    }
}
