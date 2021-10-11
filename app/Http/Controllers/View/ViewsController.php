<?php

namespace App\Http\Controllers\View;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class ViewsController extends Controller
{
    public function register(Request $request)
    {
        $token = $request->get('token', '');
        $role = User::ROLE_LIST;
        unset($role[User::ROLE_SCHOOL]);
        return view('register')->with('token', $token)->with('role', $role);
    }

    public function login(Request $request)
    {
        $lineOauth = 'https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=' .
            env('LINE_CLIENT_ID') . '&redirect_uri=' . urlencode(config('app.url') . '/callback/line/callback') .
            '&state=' . time() . str_random(random_int(20, 30)) .
            '&scope=profile%20openid%20email&nonce=' . time();
        return view('login', ['lineOauth' => $lineOauth]);
    }

    public function stulist(Request $request)
    {
        return view('stulist');
    }
    public function teacherlist(Request $request)
    {
        return view('teacherlist');
    }
    public function teacheralllist(Request $request)
    {
        return view('teacheralllist');
    }

    public function followlist(Request $request)
    {
        return view('followList');
    }
}
