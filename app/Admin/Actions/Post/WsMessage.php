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
        $this->sendLine($model->line_openid, $msg);

        return $this->response()->success('Success message.')->refresh();
    }

    public function form()
    {
        $this->textarea('message', '请输入消息内容')->rules('required');
    }

    private function sendLine(string $lineOpenid, string $message)
    {
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(
            'zAQauSOwa16W4PNWRiFU4TImQlr1kHBZj6Iwtxl12nML8LjfgT1zMYgl2R7Dlb9qHYD9ITozS+GXwGRb/PpA3cMeP5mR2ZCqipRz0OMSTaOmDnKDzdVq8Pah/NzaWhzzNzIiNNwXyvD2yOg4HLkiLAdB04t89/1O/w1cDnyilFU='
        );
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => 'bc7716b6a604d6d6a6c47ff890fbac03']);

        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
        $bot->pushMessage('U29b01b3089dd0ae0e563b346823a5854', $textMessageBuilder);

        //$response = $bot->pushMessage('<to>', $textMessageBuilder);
        //echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
    }
}
