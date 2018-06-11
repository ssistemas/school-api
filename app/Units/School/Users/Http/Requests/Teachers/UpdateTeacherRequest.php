<?php

namespace Emtudo\Units\School\Users\Http\Requests\Teachers;

use Emtudo\Domains\Users\Teacher;
use Emtudo\Support\Http\Request;
use Illuminate\Validation\Rule;

class UpdateTeacherRequest extends Request
{
    public function rules()
    {
        return Teacher::rules()->updating(function ($rules) {
            $id = decode_id($this->route('teacher'));

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
