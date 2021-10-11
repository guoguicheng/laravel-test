<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>教师列表</title>

    @include('block.head')
</head>

<body>
    <div class="center">
        @include('block.header')
        <table class="table">
            <caption>教师列表</caption>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>名称</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody id="rows">
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
        $(function() {
            var token = JSON.parse(localStorage.getItem('token'));
            var tk = token.token_type + ' ' + token.access_token;
            var data = {
                'min_id': 0
            };
            request('/api/teacher/alllist', 'get', data, function(data) {
                console.log(data);
                var row = '';
                for (var i = 0; i < data.length; i++) {
                    row += '<tr><td>' + data[i].id + '</td><td>' + data[i].name;
                    if (data[i].following) {
                        row += '</td><td><button type="button" class="btn btn-default unfollow" tid="' +
                            data[i].id + '">取消关注</button></td></tr>';
                    } else {
                        row += '</td><td><button type="button" class="btn btn-success follow" tid="' +
                            data[i].id + '">关注</button></td></tr>';
                    }
                }
                $(row).appendTo("#rows");
                $(".follow").on('click', function(e) {
                    e.stopPropagation();
                    var that = this;
                    var tid = $(this).attr('tid');
                    var data = {
                        "teacher_id": tid
                    }
                    request('/api/teacher/follow', 'post', data, function(data) {
                        $(that).removeClass('follow');
                        $(that).removeClass('btn-success');
                        $(that).addClass('unfollow');
                        $(that).addClass('btn-default');
                        $(that).html('取消关注');
                    }, tk);
                })
                $(".unfollow").on('click', function(e) {
                    e.stopPropagation();
                    var tid = $(this).attr('tid');
                    var that = this;
                    var data = {
                        "teacher_id": tid
                    }
                    request('/api/teacher/unfollow', 'put', data, function(data) {
                        $(that).removeClass('unfollow');
                        $(that).removeClass('btn-default');
                        $(that).addClass('follow');
                        $(that).addClass('btn-success');
                        $(that).html('关注');
                    }, tk);
                })
            }, tk);

        })
    </script>
</body>

</html>