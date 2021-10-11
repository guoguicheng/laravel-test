<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Follows;
use Illuminate\Http\Request;
use App\Exceptions\ApiException;
use App\Http\Requests\UserRequest;
use App\Http\Requests\FollowRequest;

class StudentController extends Controller
{
    public function getAllTeacherList(UserRequest $request, User $userModel, Follows $followModel)
    {
        $minId = $request->min_id;
        $id = $request->user()->id;

        $where = ['role' => User::ROLE_TEACHER, 'enable' => User::ENABLE_TRUE];

        if ($minId) {
            $where[] = ['id', '<', $minId];
        }
        $list = $userModel->where($where)->orderBy('id', 'desc')->take(15)->get()->toArray();

        $followingList = $followModel->where('student_id', $id)->pluck('teacher_id')->toArray();

        foreach ($list as $k => $v) {
            $list[$k]['following'] = in_array($v['id'], $followingList) ? 1 : 0;
        }

        return response()->json($list);
    }

    public function followTeacher(FollowRequest $request, Follows $followModel, User $userModel)
    {
        $tId = $request->teacher_id;
        $tInfo = $userModel->find($tId);
        if ($tInfo->role !== User::ROLE_TEACHER) {
            throw new ApiException('只能关注老师');
        }

        $data = ['teacher_id' => $tId, 'student_id' => $request->user()->id];

        if ($followModel->where($data)->count() > 0) {
            throw new ApiException('请勿重复关注');
        }

        $followModel->create($data);

        return response()->json(['message' => '关注成功'], 201);
    }
    public function unFollowTeacher(FollowRequest $request, Follows $followModel)
    {
        $where = ['teacher_id' => $request->teacher_id, 'student_id' => $request->user()->id];
        $followModel->where($where)->delete();

        return response()->json(['message' => '取消关注成功'], 201);
    }
}
