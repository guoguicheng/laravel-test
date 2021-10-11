<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Exceptions\ApiException;

class AuthSchoolMiddleware
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
        $uinfo = User::find($request->user()->id);
        if (empty($uinfo) || $uinfo->role !== User::ROLE_SCHOOL) {
            throw new ApiException('非学校角色无法操作');
        }
        if ($uinfo->enable === User::ENABLE_FALSE) {
            throw new ApiException('用户被禁用');
        }
        return $next($request);
    }
}
