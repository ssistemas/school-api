<?php

namespace Emtudo\Units\Files\Http\Requests;

use Emtudo\Support\Http\Request;

class UploadTemporaryRequest extends Request
{
    public function rules()
    {
        return [
            'kind' => 'required|max:255',
            'file' => 'required|file|mimes:pdf,jpeg,jpg,png,xml,txt,doc,docx,xls,xlsx,p12|max:4096',
        ];
    }
}
