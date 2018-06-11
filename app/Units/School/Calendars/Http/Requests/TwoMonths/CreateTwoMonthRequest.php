<?php

namespace Emtudo\Units\School\Calendars\Http\Requests\TwoMonths;

use Emtudo\Domains\Calendars\TwoMonth;
use Emtudo\Support\Http\Request;

class CreateTwoMonthRequest extends Request
{
    public function rules()
    {
        return TwoMonth::rules()->creating();
    }

    public function attributes()
    {
        return [
            'id' => 'ano',
            'start1' => 'data inicial do bimestre 1',
            'end1' => 'data final do bimestre 1',
            'start2' => 'data inicial do bimestre 2',
            'end2' => 'data final do bimestre 2',
            'start3' => 'data inicial do bimestre 3',
            'end3' => 'data final do bimestre 3',
            'start4' => 'data inicial do bimestre 4',
            'end4' => 'data final do bimestre 4',
        ];
    }
}
