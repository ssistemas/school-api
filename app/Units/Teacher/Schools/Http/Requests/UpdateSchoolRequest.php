<?php

namespace Emtudo\Units\Teacher\Schools\Http\Requests;

use Emtudo\Domains\Tenants\Tenant;
use Emtudo\Support\Http\Request;
use Illuminate\Validation\Rule;

class UpdateSchoolRequest extends Request
{
    public function rules()
    {
        return Tenant::rules()->updating(function ($rules) {
            $id = decode_id($this->route('school'));

            return array_merge($rules, [
                'email' => [
                    'required',
                    'string',
                    'max:255',
                    'email',
                    Rule::unique('tenants')
                        ->ignore($id),
                ],
                'country_register' => [
                    'required',
                    'cnpj',
                    Rule::unique('tenants')
                        ->ignore($id),
                ],
            ]);
        });
    }
}
