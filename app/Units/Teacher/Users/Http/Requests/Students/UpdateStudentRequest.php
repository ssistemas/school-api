<?php

namespace Emtudo\Units\Teacher\Users\Http\Requests\Students;

use Emtudo\Domains\Users\Student;
use Emtudo\Support\Http\Request;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends Request
{
    public function rules()
    {
        return Student::rules()->updating(function ($rules) {
            $id = decode_id($this->route('student'));

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
