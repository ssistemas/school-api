<?php

namespace Emtudo\Domains\Calendars\Transformers;

use Emtudo\Domains\Calendars\TwoMonth;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class TwoMonthTransformer extends Transformer
{
    /**
     * @param TwoMonth $twoMonth
     *
     * @return array
     */
    public function transform(TwoMonth $twoMonth)
    {
        return [
            'id' => (int) $twoMonth->id,
            'start1' => $twoMonth->getValue('start1'),
            'end1' => $twoMonth->getValue('end1'),
            'start2' => $twoMonth->getValue('start2'),
            'end2' => $twoMonth->getValue('end2'),
            'start3' => $twoMonth->getValue('start3'),
            'end3' => $twoMonth->getValue('end3'),
            'start4' => $twoMonth->getValue('start4'),
            'end4' => $twoMonth->getValue('end4'),
        ];
    }
}
