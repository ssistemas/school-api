<?php

namespace Emtudo\Support\Response\Json\Contracts;

interface Response
{
    const NOT_FOUND = 'NOT_FOUND';
    const INTERNAL_ERROR = 'INTERNAL_ERROR';
    const INVALID_ARGUMENT = 'INVALID_ARGUMENT';

    /**
     * @return array
     */
    public function getData();

    /**
     * @param array $data
     *
     * @return Response
     */
    public function setData(array $data);

    /**
     * @return array
     */
    public function getMeta();

    /**
     * @param array $meta
     *
     * @return Response
     */
    public function setMeta($meta);

    /**
     * @param $statusCode
     *
     * @return Response
     */
    public function setStatusCode($statusCode);

    /**
     * @return int
     */
    public function getStatusCode();

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function make();
}
