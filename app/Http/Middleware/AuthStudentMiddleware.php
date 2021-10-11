<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use App\User;
use Closure;

class AuthStudentMiddleware
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
        if (empty($uinfo) || $uinfo->role !== User::ROLE_STUDENT) {
            throw new ApiException('非学生角色无法操作');
        }
        if ($uinfo->enable === User::ENABLE_FALSE) {
            throw new ApiException('用户被禁用');
        }
        return $next($request);
    }
}
