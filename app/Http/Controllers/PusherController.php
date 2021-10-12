<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\PusherRequest;
use App\Service\PusherService;
use App\User;

class PusherController extends Controller
{
    public function to(PusherRequest $request, PusherService $pusher, User $user)
    {
        $params = $request->only(['to', 'msg']);

        $fromId = $request->user()->id;
        $uinfo = $user->find($fromId);
        if (empty($uinfo)) {
            throw new ApiException('用户不存在');
        }
        $data = [
            'from' => $fromId, 'name' => $uinfo->name, 'message' => $params['msg']
        ];
        // 发送到消息提醒
        $pusher->sendTo('chat', $params['to'], '', $data);

        return response()->json(['message' => 'ok']);
    }
}
