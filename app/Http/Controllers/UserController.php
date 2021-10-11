<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\FollowRequest;
use App\Http\Requests\UserRequest;
use App\Models\Follows;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $model;
    function __construct(User $user)
    {
        $this->model = $user;
    }
    public function getSchoolList(UserRequest $request)
    {
        $where = []; //['role' => User::ROLE_SCHOOL, 'enable' => User::ENABLE_TRUE];
        $minId = $request->min_id;
        if ($minId) {
            $where[] = ['id', '<', $minId];
        }
        $list = $this->model->where($where)->orderBy('id', 'desc')->take(15)->get();

        return response()->json($list);
    }

    public function getTeacherList(UserRequest $request)
    {
        $where = ['role' => User::ROLE_TEACHER, 'enable' => User::ENABLE_TRUE];
        $minId = $request->min_id;
        if ($minId) {
            $where[] = ['id', '<', $minId];
        }
        $list = $this->model->where($where)->orderBy('id', 'desc')->take(15)->get();

        return response()->json($list);
    }

    
}
