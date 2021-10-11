<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Follows;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class TeacherController extends Controller
{
    public function getStudentList(UserRequest $request, User $userModel)
    {
        $minId = $request->min_id;
        $pid = $request->user()->id;

        $where = ['role' => User::ROLE_STUDENT, 'enable' => User::ENABLE_TRUE, 'pid' => $pid];

        if ($minId) {
            $where[] = ['id', '<', $minId];
        }
        $list = $userModel->where($where)->orderBy('id', 'desc')->take(15)->get();

        return response()->json($list);
    }

    public function getFollowList(Request $request, Follows $followModel)
    {
        $tid = $request->user()->id;

        $where = [['teacher_id', '=', $tid]];
        $minId = $request->get('min_id', '');
        if ($minId) {
            $where[] = ['id', '<', $minId];
        }
        $list = $followModel->where($where)->with('teacherInfo', 'studentInfo')
            ->orderBy('id', 'desc')->take(15)->get();

        return response()->json($list);
    }
}
