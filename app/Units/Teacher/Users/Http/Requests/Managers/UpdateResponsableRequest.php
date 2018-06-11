<?php

namespace Emtudo\Units\Teacher\Users\Http\Requests\Managers;

use Emtudo\Domains\Responsibles\Manager;
use Emtudo\Support\Http\Request;
use Illuminate\Validation\Rule;

class UpdateResponsibleRequest extends Request
{
    public function rules()
    {
        return Manager::rules()->updating(function ($rules) {
            $id = decode_id($this->route('responsible'));

            return array_merge($rules, [
                'email' => [
                    'required',
                    'string',
                    'max:255',
                    'email',
                    Rule::unique('users')
                        ->ignore($id),
                ],
                'country_register' => [
                    'required',
                    'cpf',
                    Rule::unique('users')
                        ->ignore($id),
                ],
            ]);
        });
    }
}
