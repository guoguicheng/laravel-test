<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>与{{$name}}的聊天</title>

    @include('block.head')
    <style>
        .from {
            text-align: left;
            width: 100%;
        }

        .me {
            text-align: right;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="center">
        @include('block.header')
        <div id="chat_msg"></div>

        <div class="row">
            <form class="bs-example bs-example-form" role="form" onsubmit="javascript:return false;">
                <div class="col-lg-12">
                    <div class="input-group col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                与 {{$name}} 对话
                            </div>
                            <div class="panel-body" id="pannel-body">
                                @if($msg)
                                <p class="from">{{$name}}：{{$msg}}</p>
                                @endif
                            </div>
                        </div>
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
                <hr />
                <div class="col-lg-12">
                    <div class="input-group">
                        <input type="hidden" value="{{$to}}" id="to" />
                        <input type="text" class="form-control" id="msg">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" id="send">Send</button>
                        </span>
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
        </form>
    </div>
    <script type="text/javascript">
        $(function() {
            var tokenStr = localStorage.getItem('token');
            var windowId = getUuid();
            var to = $("#to").val();
            if (!to) {
                alert('参数错误,请重新打开当前对话页面');
                return;
            }
            if (!tokenStr) {
                alert('请先登录');
                return;
            }
            var token = JSON.parse(tokenStr);
            var tk = token.token_type + ' ' + token.access_token;
            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;

            var pusher = new Pusher('7008746543badafd282a', {
                cluster: 'mt1'
            });

            var channel = pusher.subscribe('chat');
            request('/api/user', 'get', {}, function(res) {
                channel.bind(res.id, function(data) {
                    console.log(data);
                    if (data.from != to) {
                        var url = '/chat?to=' + data.from + '&name=' + data.name + '&msg=' + data.message;
                        $('<div class="alert alert-success id' + data.from + '" url="' + url + '"><strong>' +
                            data.name + '</strong> ' + data.message + '</div>').appendTo('#chat_msg');
                        $(".id" + data.from).on('click', function(e) {
                            var href = $(this).attr('url');
                            $(this).remove();
                            window.open(href, '_blank');
                        })
                    } else {
                        $('<p class="from">' + data.name + '：' + data.message + '</p>').appendTo('#pannel-body');
                    }
                });
                console.log('websocket 绑定成功');
            }, tk);

            $("#send").on('click', function(e) {
                e.stopPropagation();
                sendMsg();
            })
            $(document).keyup(function(event) {
                if (event.keyCode == 13) {
                    sendMsg();
                }
            });

            function sendMsg() {
                var msg = $("#msg").val();
                var data = {
                    'to': to,
                    'msg': msg
                }
                request('/api/message/to', 'POST', data, function(data) {
                    $("#msg").val('');
                    $('<p class="me">你：' + msg + '</p>').appendTo('#pannel-body');
                }, tk);
            }

        })
    </script>
</body>

</html>