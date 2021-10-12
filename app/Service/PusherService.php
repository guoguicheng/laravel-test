<?php

namespace App\Service;

use Pusher\Pusher;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class PusherService
{
    private $pusher;
    function __construct()
    {
        $params = [
            'auth_key' => config('broadcasting.connections.pusher.key'),
            'secret' => config('broadcasting.connections.pusher.secret'),
            'app_id' => config('broadcasting.connections.pusher.app_id')
        ];
        /** @var Pusher */
        $this->pusher = app(Pusher::class, $params);
    }

    /**
     * 发送websocket
     *
     * @param string $channel
     * @param string $event
     * @param string $message 如果$data参数不为空则忽略$message参数
     * @param array $data 发送内容
     * @return void
     */
    public function sendTo(string $channel, string $event, string $message, array $data = [])
    {
        $body = $data;
        if (empty($data)) {
            $body = ['message' => $message];
        }
        $this->pusher->trigger($channel, $event, $body);;
    }
}
