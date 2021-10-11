<?php

namespace App\Http\Controllers;

use App\User;
use App\Service\MailService;
use Illuminate\Http\Request;
use App\Exceptions\ApiException;
use App\Http\Requests\UserRequest;
use App\Http\Requests\InviteRequest;

class SchoolController extends Controller
{
    private $userModel;
    function __construct(User $model)
    {
        $this->userModel = $model;
    }
    public function getTeacherList(UserRequest $request)
    {
        $minId = $request->min_id;
        $pid = $request->user()->id;

        $where = ['role' => User::ROLE_TEACHER, 'enable' => User::ENABLE_TRUE, 'pid' => $pid];

        if ($minId) {
            $where[] = ['id', '<', $minId];
        }
        $list = $this->userModel->where($where)->orderBy('id', 'desc')->take(15)->get();

        return response()->json($list);
    }

    public function inviteTeacher(InviteRequest $request, MailService $mail)
    {
        $schoolInfo = $this->userModel->find($request->user()->id);
        if (empty($schoolInfo)) {
            throw new ApiException('学校不存在');
        }
        if ($schoolInfo->role !== User::ROLE_SCHOOL) {
            throw new ApiException('只有学校能邀请老师');
        }
        $title = $schoolInfo->name . '学校邀请您成为老师';
        $body = '访问 ' . config('app.url') . '/register?school_id=' . $schoolInfo->id . ' 完成注册';
        $bSent = $mail->sendEmail($request->post('email'), $title, $body);
        if (!$bSent) {
            throw new ApiException('邮件发送失败');
        }
        return response()->json(['message' => '发送成功'], 200);
    }
}
