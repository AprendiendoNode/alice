<?php

namespace App\Exceptions;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    use ApiResponser;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     *
     * public function render($request, Exception $exception)
     *{
     *    return parent::render($request, $exception);
     *}
    */
    public function render($request, Exception $exception)
    {
        if($request->expectsJson()) {
            if ($exception instanceof ValidationException) {

                if ($exception->response) {
                    return $exception->response;
                }

                if ($request->expectsJson()) {
                    //return $this->errorResponse($exception->validator->errors()->getMessages(), 422);
                    return $this->errorResponse($exception->errors(), 422);
                }
            }
        }
        return parent::render($request, $exception);
    }
}
