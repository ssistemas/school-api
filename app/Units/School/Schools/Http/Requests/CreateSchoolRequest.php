<?php

namespace Emtudo\Units\School\Schools\Http\Requests;

use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Support\Http\Request;

class CreateSchoolRequest extends Request
{
    public function rules()
    {
        return Tenant::rules()->creating();
    }
}
