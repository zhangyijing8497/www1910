<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Redis;
use Closure;

class AccessFilter
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
        // 获取url
        $request_uri = $_SERVER['REQUEST_URI']; 
        $url_hash = substr(md5($request_uri),0,10);
        $max = env('API_ACCESS_MAX');
        $expire = env('API_ACCESS_TIMEOUT');
        $time_last = env('API_ACCESS_TIME_LAST');
        
        $key = 'count_url_' . $url_hash;
        $total = Redis::get($key);
        if($total > $max){
            $response = [
                'errno'     => 50013,
                'msg'       => "请求过于频繁,请{$expire}秒后重试"
            ];

            // 设置key的过期时间
            Redis::expire($key,$expire);
            // return response()->json($response);
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }else{
            Redis::incr($key);
            Redis::expire($key,$time_last);
        }
        return $next($request);
    }
}
