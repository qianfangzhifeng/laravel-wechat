<?php

namespace Qianfangzhifeng\LaravelWechat\Http\Middleware;

use Closure;

class SwechatCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 手动新增的参数
        // 只有在第一次对接的时候才会存在
        // 因此可以根据这个参数来判断是否之前校验过
        $signature = $request -> input('signature');
        $timestamp = $request -> input('timestamp');
        $nonce     = $request -> input('nonce');
        $echostr   = $request -> input('echostr');
        // 加密过程
        $sign      = $this -> sign($timestamp,$nonce);
        if( $sign == $signature ){
            // 额外修改的代码
            if (empty($echostr)) { // 是否有关联
                return $next($request);
            } else {
                return response($echostr);
            }
        }else{
            return response(false);
        }

    }

    /**
     * 加密
     * @param $timestamp
     * @param $nonce
     * @return string
     */
    private function sign($timestamp,$nonce){
        $token   = config('swechat.wechat_config')['token'];
        $tmpArr  = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $sign    = sha1( implode( $tmpArr ) );
        return $sign;
    }
}
