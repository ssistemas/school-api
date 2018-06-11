<?php

namespace Emtudo\Domains;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use ResultSystems\Relationships\Traits\RelationshipsTrait;

abstract class Model extends EloquentModel
{
    use RelationshipsTrait;

    protected $transformerClass;

    /**
     * @return string
     */
    public function getTransformerClass()
    {
        return $this->transformerClass;
    }

    /**
     * @return League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return app()->make($this->getTransformerClass());
    }

    /**
     * @return Spatie\Fractal\Fractal
     */
    public function transform()
    {
        return fractal()->item($this, $this->getTransformer())->getResource();
    }

    public function publicId()
    {
        return app('hash.id')->encode($this->id);
    }

    public function getValue($key)
    {
        $value = array_get($this->attributes, $key, null);

        if ($value instanceof Carbon) {
            return $value->format('Y-m-d H:i:s');
        }

        return $value;
    }
}
