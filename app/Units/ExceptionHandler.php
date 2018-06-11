<?php

namespace Emtudo\Units;

use Emtudo\Support\Exception\Handler;
use Emtudo\Support\Http\Respond;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceptionHandler extends Handler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Create a response object from the given validation exception.
     *
     * @param \Illuminate\Validation\ValidationException $e
     * @param \Illuminate\Http\Request                   $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        // get the failed validation messages.
        $errors = $e->validator->errors()->getMessages();

        $respond = new Respond();

        return $respond->invalid($errors, $e->getMessage());
//        // returns an failed validation response.
        //        return response()->json([
        //            'data' => [
        //                'error' => $e->getMessage(),
        //                'errors' => $errors,
        //                'code' => 422
        //            ]
        //        ], 422);
    }

    /**
     * Render the given HttpException.
     *
     * @param \Symfony\Component\HttpKernel\Exception\HttpException $e
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException(HttpException $e)
    {
        return $this->convertExceptionToResponse($e);
    }

    /**
     * Create a Symfony response for the given exception.
     *
     * @param \Exception $e
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertExceptionToResponse(Exception $e)
    {
        // flat the exception.
        $e = FlattenException::create($e);

        // detect debug mode.
        $debug = config('app.debug', false);

        // get exception message.
        $message = $e->getMessage();

        // if the debug mode is on or there is no message...
        if ($debug || !$message) {
            // get the default matching http response message.
            $message = array_get(Response::$statusTexts, $e->getStatusCode());
        }

        // get the exception trace if in debug mode.
        $trace = $debug ? $this->flattenTrace($e->getTrace()) : null;

        // return the api exception response.
        return response()->json(['data' => [
            'error' => $message,
            'code' => $e->getStatusCode(),
            'trace' => $trace,
        ]], $e->getStatusCode(), $e->getHeaders());
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param \Illuminate\Http\Request                 $request
     * @param \Illuminate\Auth\AuthenticationException $exception
     *
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // returns a default authentication exception.
        return response()->json(['data' => ['error' => 'Unauthenticated.', 'code' => 401]], 401);
    }

    /**
     * Flatten the stack trace into a simple format.
     *
     * @param array $stackTrace
     *
     * @return array
     */
    protected function flattenTrace(array $stackTrace = [])
    {
        $trace = collect((array) $stackTrace);

        return $trace->map(function ($error) {
            return collect((array) $error)->only(['class', 'file', 'line']);
        })->all();
    }
}
