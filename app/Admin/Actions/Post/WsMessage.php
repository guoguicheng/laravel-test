<?php

namespace App\Admin\Actions\Post;

use App\Service\PusherService;
use Illuminate\Http\Request;
use Encore\Admin\Actions\RowAction;
use Encore\Admin\Facades\Admin;
use Illuminate\Database\Eloquent\Model;

class WsMessage extends RowAction
{
    public $name = '发送消息';

    public function handle(Model $model, Request $request)
    {
        // $model ...
        $msg = $request->get('message');
        /** @var PusherService */
        $pusher = app(PusherService::class);

        $uinfo = Admin::user();
        $data = [
            'from' => $uinfo->id, 'name' => $uinfo->name, 'message' => $msg
        ];
        $pusher->sendTo('chat', $model->id, '', $data);

        return $this->response()->success('Success message.')->refresh();
    }

    public function form()
    {
        $this->textarea('message', '请输入消息内容')->rules('required');
    }
}
