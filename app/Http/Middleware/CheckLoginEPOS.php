<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Psr\Container\NotFoundExceptionInterface;

class CheckLoginEPOS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            if(!$request->session()->has("pwd"))
            {
                return redirect()->route('epos_login');
            }
            return $next($request);
        } catch (NotFoundExceptionInterface $e) {
            return response()->json(["status"=>"fail","message"=>"中间件处理时发生错误，详细如下".$e,"data"=>""]);
        }
    }
}
