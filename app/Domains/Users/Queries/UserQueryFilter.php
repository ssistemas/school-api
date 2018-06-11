<?php

namespace Emtudo\Domains\Users\Queries;

use Carbon\Carbon;
use Emtudo\Support\Queries\BaseQueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class UserQueryFilter extends BaseQueryBuilder
{
    /**
     * @return EloquentQueryBuilder|QueryBuilder
     */
    public function getQuery()
    {
        $this->applyWhere(['id', 'country_register']);
        $this->applyLike(['name', 'email']);
        $this->byAddress();
        $this->byPhone();
        $this->byBirthDays();

        return $this->query;
    }

    public function getBirthdays($when = 'today')
    {
        if ('today' === $when) {
            $today = Carbon::now()->format('md');
            $this->query->whereRaw("DATE_FORMAT(birthdate, '%m%d') = {$today}");
        }
        if ('week' === $when) {
            $firstDay = Carbon::now()->startOfWeek()->format('md');
            $lastDay = Carbon::now()->endOfWeek()->format('md');
            $this->query->whereRaw("DATE_FORMAT(birthdate, '%m%d') between {$firstDay} and {$lastDay}");
        }
        if ('month' === $when) {
            $firstDay = Carbon::now()->startOfMonth()->format('md');
            $lastDay = Carbon::now()->endOfMonth()->format('md');
            $this->query->whereRaw("DATE_FORMAT(birthdate, '%m%d') between {$firstDay} and {$lastDay}");
        }

        return $this->query;
    }

    protected function byBirthdays()
    {
        $birthday = array_get($this->params, 'birthday', null);

        if (!$birthday) {
            return;
        }

        $this->getBirthdays($birthday);
    }

    protected function byPhone()
    {
        $phone = array_get($this->params, 'phone', null);

        if (!$phone) {
            return;
        }

        $this->query->where(function ($query) use ($phone) {
            return $query->where('phones->mobile', 'LIKE', "%$phone%")
                ->orWhere('phones->work', 'LIKE', "%$phone%")
                ->orWhere('phones->home', 'LIKE', "%$phone%");
        });
    }

    protected function byAddress()
    {
        $address = array_get($this->params, 'address', null);

        if (!$address) {
            return;
        }

        $this->query->where(function ($query) use ($address) {
            return $query->where('address->street', 'LIKE', "%$address%")
                ->orWhere('address->district', 'LIKE', "%$address%")
                ->orWhere('address->city', 'LIKE', "%$address%");
        });
    }
}
