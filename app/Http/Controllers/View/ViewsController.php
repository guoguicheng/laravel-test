<?php

namespace App\Http\Controllers\View;

use App\Exceptions\WebException;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ViewsController extends Controller
{
    public function error(Request $request)
    {
        $msg = $request->get('msg');
        return view('error')->with('msg', $msg);
    }
    public function chat(Request $request)
    {
        $data = $request->only(['to', 'name', 'msg']);
        $valid = Validator::make($data, [
            'to' => 'required|min:1',
            'name' => 'required|min:1',
            'msg' => 'nullable'
        ]);
        if ($valid->fails()) {
            throw new WebException('参数有误');
        }
        return view('chat')->with('to', $data['to'])->with('name', $data['name'])->with('msg', $data['msg'] ?? '');
    }
    public function websocket(Request $request)
    {
        return view('websocket');
    }
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
            '&scope=profile openid email&nonce=' . time();
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
