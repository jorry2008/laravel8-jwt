<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    // 重写认证方法
    public function handle($request, \Closure $next, ...$guards)
    {
        if (in_array(config('auth.defaults.guard'), $guards)) { // 如果是api类型，就不要跳转
            if ($this->apiAuthenticate(config('auth.defaults.guard')) === false) { // 直接返回 json
                return Controller::StaticResponse([], '身份未认证，请先登录认证', 401);
            }
        } else {
            $this->authenticate($request, $guards);
        }

        return $next($request);
    }

    // 单独处理 api 未认证返回值
    protected function apiAuthenticate($guard)
    {
        if ($this->auth->guard($guard)->check()) {
            return $this->auth->shouldUse($guard);
        }
        return false;
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login'); // web 验证失败跳转到登录页面
        }
    }
}
