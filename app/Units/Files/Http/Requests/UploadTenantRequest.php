<?php

namespace Emtudo\Units\Files\Http\Requests;

use Emtudo\Support\Http\Request;

class UploadTenantRequest extends Request
{
    public function rules()
    {
        return [
            'kind' => 'required|max:255',
            'uuid' => 'required|exists:files,uuid',
        ];
    }
}
