<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
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
        \App\Exceptions\MyException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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
     */
    public function render($request, Exception $exception)
    {
        // Illuminate\Database\QueryException;     // mysql 1062,Duplicate entry '' for key 'users_email_unique'

        if ($request->expectsJson()) {      // 如果是 ajax, 返回json 相应
            if ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
                $message = !empty($exception->getMessage()) ? $exception->getMessage() : "对不起，您不能访问该方法";
                return response()->json(['error' => 403, 'info' => $message]);
            }

            if ($exception instanceof \Illuminate\Validation\ValidationException) {
                $errors = $exception->validator->errors()->toArray();
                return response()->json(['error' => 422, 'info' => current($errors)[0]]);
            }

            if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                $message = "您访问的数据走丢了";
                return response()->json(['error' => 422, 'info' => $message]);
            }

            if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                $message = "您访问的页面飞走了";
                return response()->json(['error' => 404, 'info' => $message]);
            }

            if ($exception instanceof \App\Exceptions\MyException) {
                $error = isset($exception->errorCode) ? $exception->errorCode : 500;
                $message = !empty($exception->getMessage()) ? $exception->getMessage() : "对不起，服务器开了个小差";
                return response()->json(['error' => $error, 'info' => $message]);
            }
        }

        if (!config('app.debug')) {
            return response()->view('errors.500', [], 500);
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => '401', 'Unauthenticated.']);
        }

        return redirect()->guest(route('login'));
    }
}
