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
        return view('login');
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
