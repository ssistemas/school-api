<?php

namespace Emtudo\Support\Response\Json\Contracts;

interface Factory
{
    /**
     * @param array $data
     * @param array $meta
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function success(array $data, array $meta = []);

    /**
     * @param array $data
     * @param array $meta
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function notFound(array $data, array $meta = []);
}
