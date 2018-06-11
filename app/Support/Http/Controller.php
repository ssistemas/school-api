<?php

namespace Emtudo\Support\Http;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var array includes Transformer
     */
    protected $includes = [];

    /**
     * @var int number of items per page on index
     */
    protected $itemsPerPage = 30;

    protected $params = [];

    protected $pagination = true;

    protected $cleanTypes = [
        'document' => 'removeChars',
        'zip' => 'removeChars',
        'phone' => 'removeChars',
        'checkbox' => 'fixCheckbox',
        'select' => 'fixSelect',
        'ccNumber' => 'removeSpaces',
        'ccDate' => 'removeSpaces',
        'id' => 'fixId',
    ];

    protected $cleaningRules = [];

    /**
     * @var \Emtudo\Domains\Users\User
     */
    protected $user;

    /**
     * @var \Emtudo\Support\Http\Respond
     */
    protected $respond;

    /**
     * Controller constructor.
     *
     * Uses a middleware to always detect the running user on all requests.
     */
    public function __construct()
    {
        $this->respond = new Respond();

        $this->middleware(function ($request, $next) {
            $this->user = app('auth')->user();

            $this->itemsPerPage = (int) $request->get('limit', 30);
            $this->params = $this->cleanFields($request->all());

            $this->pagination = $request->get('pagination', true);
            $this->pagination = filter_var($this->pagination, FILTER_VALIDATE_BOOLEAN);

            $this->includes = $request->get('includes', []);
            if (!is_array($this->includes)) {
                $this->includes = explode(',', $this->includes);
            }

            return $next($request);
        });
    }

    /**
     * @param string $hashedId
     *
     * @return int
     */
    public function revealId($hashedId)
    {
        return app('hash.id')->decode($hashedId);
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function parseIncludes(Request $request)
    {
        if ($request->has('include')) {
            return (array) explode(',', $request->get('include'));
        }

        return [];
    }

    protected function cleanFields($data = [], $rules = null)
    {
        $newRules = $rules ?? $this->cleaningRules;

        foreach ($newRules as $field => $type) {
            if (isset($data[$field]) && is_array($type)) {
                $data[$field] = $this->cleanFieldsRecursive($data[$field], $type);
            }
            if (isset($data[$field]) && !is_array($type)) {
                $method = $this->cleanTypes[$type];
                $data[$field] = $this->$method($data[$field]);
            }
        }

        return $data;
    }

    protected function cleanFieldsRecursive($data = [], $rules = [])
    {
        $newData = [];
        foreach ($data as $key => $item) {
            $newData[] = $this->cleanFields($item, $rules);
        }

        return $newData;
    }

    protected function removeChars($value)
    {
        return str_replace(['(', ')', '-', '/', '.', ' '], '', $value);
    }

    protected function removeSpaces($value)
    {
        return str_replace(' ', '', $value);
    }

    protected function fixCheckbox($value)
    {
        if ('on' === $value) {
            return true;
        }

        if ('off' === $value) {
            return false;
        }

        return $value;
    }

    /**
     * @param $value
     *
     * @return null|int
     */
    protected function fixId($value)
    {
        if ($value) {
            return decode_id($value);
        }

        return null;
    }

    protected function fixSelect($value)
    {
        if ('' === $value) {
            return null;
        }

        return $value;
    }

    /**
     * @return \Illuminate\Http\Request
     */
    protected function getRequest()
    {
        return app('request');
    }

    /**
     * @return \Illuminate\Auth\AuthManager
     */
    protected function getAuth()
    {
        return app('auth');
    }

    /**
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function getGuard()
    {
        return $this->getAuth()->guard();
    }
}
