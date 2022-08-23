<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public const RESPONSE_CODE = 'code'; // int 错误码，非 0 表示失败
    public const RESPONSE_MSG = 'msg'; // string 错误描述
    public const RESPONSE_DATA = 'data'; // [] 返回的信息

    // 统一响应格式
    protected function response($data, $msg = '', $code = 200)
    {
        return response()->json([
            static::RESPONSE_CODE => $code,
            static::RESPONSE_MSG => $msg,
            static::RESPONSE_DATA => $data,
        ], $code);
    }

    // 外部调用
    public static function StaticResponse($data, $msg = '', $code = 200)
    {
        return response()->json([
            static::RESPONSE_CODE => $code,
            static::RESPONSE_MSG => $msg,
            static::RESPONSE_DATA => $data,
        ], $code);
    }

    // 收集的状态码列表
//    记录不存在	404
//    请求成功	200
//    创建成功	201
//    参数不正确	400
//    未授权	401
}
