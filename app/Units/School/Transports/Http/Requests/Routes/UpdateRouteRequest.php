<?php

namespace Emtudo\Units\School\Transports\Http\Requests\Routes;

use Emtudo\Domains\Transports\Route;
use Emtudo\Support\Http\Request;
use Illuminate\Validation\Rule;

class UpdateRouteRequest extends Request
{
    public function rules()
    {
        return Route::rules()->updating(function ($rules) {
            $id = decode_id($this->route('route'));

            return array_merge($rules, [
                'label' => [
                    'required',
                    'string',
                    'max:60',
                    Rule::unique('routes')
                        ->ignore($id),
                ],
            ]);
        });
    }
}
