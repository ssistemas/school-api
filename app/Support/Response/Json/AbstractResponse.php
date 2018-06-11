<?php

namespace Emtudo\Support\Response\Json;

use Emtudo\Support\Response\Json\Contracts\Response as ResponseContract;
use Illuminate\Http\Response as IlluminateResponse;

abstract class AbstractResponse implements ResponseContract
{
    protected $statusCode = IlluminateResponse::HTTP_OK;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    private $meta = [];

    public function __construct(array $data = [], array $meta = [])
    {
        $this->data = $data;
        $this->meta = $meta;
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param array $meta
     *
     * @return $this
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * @param $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function make()
    {
        return response()->json($this->transform());
    }

    /**
     * @return array
     */
    protected function transform()
    {
        return [
            'data' => $this->getData(),
            'statusCode' => $this->getStatusCode(),
            'meta' => $this->getMeta(),
        ];
    }
}
