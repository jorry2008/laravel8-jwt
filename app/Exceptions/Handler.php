<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;
use Api\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
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
        'current_password',
        'password',
        'password_confirmation',
    ];

    // 专门为 api 未认证做拦截
    public function render($request, Throwable $exception)
    {

        Log::info('发生了异常：'.get_class($exception));

        // 参数验证错误的异常，我们需要返回 401 的 http code 和一句错误信息
        if ($exception instanceof ValidationException) {
            return Controller::StaticResponse($exception->errors(), $exception->getMessage(), 400);
        }

        // 未登录（未授权）异常
        if ($exception instanceof AuthenticationException) { // 身份验证失败
            Log::info('未登录（未授权）异常：AuthenticationException');
//            Log::info($exception->redirectTo()); // api 响应 json，不作 http 跳转
//            Log::info($exception->guards());
//            Log::info($exception->getCode());
            return Controller::StaticResponse([], $exception->getMessage(), 401);
        }

        // 手动刷新令牌
        if ($exception instanceof UnauthorizedHttpException) { // 解析 token，如果超时，则返回 headers 参数
            Log::info('长时间未操作，超时异常：UnauthorizedHttpException');
            Log::info($exception->getHeaders()); // WWW-Authenticate
            Log::info($exception->getStatusCode());
            Log::info($exception->getCode());
            Log::info($exception->getMessage()); // Token not provided // User not found // The token has been blacklisted // Token has expired and can no longer be refreshed
            return Controller::StaticResponse([], $exception->getMessage(), 401);
        }

        // 白名单
//        TokenBlacklistedException

        return parent::render($request, $exception);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
