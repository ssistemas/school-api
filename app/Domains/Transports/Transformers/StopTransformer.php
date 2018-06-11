<?php

namespace Emtudo\Domains\Transports\Transformers;

use Emtudo\Domains\Transports\Stop;
use Emtudo\Support\Domain\Repositories\Fractal\Transformer;

class StopTransformer extends Transformer
{
    /**
     * @param Stop $stop
     *
     * @return array
     */
    public function transform(Stop $stop)
    {
        return [
            'id' => $stop->publicId(),
            'tenant_id' => encode_id($stop->tenant_id),

            'label' => $stop->label,
            'address' => $this->parseAddress($stop->address),
        ];
    }
}
