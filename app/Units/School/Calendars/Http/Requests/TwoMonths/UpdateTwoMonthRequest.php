<?php

namespace Emtudo\Units\School\Calendars\Http\Requests\TwoMonths;

use Emtudo\Domains\Calendars\TwoMonth;

class UpdateTwoMonthRequest extends CreateTwoMonthRequest
{
    public function rules()
    {
        $year = $this->route('two_month');

        return TwoMonth::rules()->updating(function ($rules) use ($year) {
            $rules['id'] = "sometimes|exists:two_months,id|in:{$year}";

            return $rules;
        });
    }
}
