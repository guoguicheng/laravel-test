<div id="chat_msg"></div>
<script>
    $(function() {
        var tokenStr = localStorage.getItem('token');
        if (!tokenStr) {
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
        request('/api/user', 'get', {}, function(data) {
            channel.bind(data.id, function(data) {
                var url = '/chat?to=' + data.from + '&name=' + data.name + '&msg=' + data.message;
                $('<div class="alert alert-success id' + data.from + '" url="' + url + '"><strong>' +
                    data.name + '</strong> ' + data.message + '</div>').appendTo('#chat_msg');
                $(".id" + data.from).on('click', function(e) {
                    var href = $(this).attr('url');
                    $(this).remove();
                    window.open(href, '_blank');
                })
            });
            console.log('websocket 绑定成功');
        }, tk);
    });
</script>