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
        @include('block.msgbar')
        <table class="table">
            <caption>教师列表</caption>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>名称</th>
                    <th>消息</th>
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
            request('/api/teacher/list', 'get', data, function(data) {
                console.log(data);
                var row = '';
                for (var i = 0; i < data.length; i++) {
                    row += '<tr><td>' + data[i].id + '</td><td>' + data[i].name +
                        '</td><td><a href="/chat?to=' + data[i].id + '&name=' + data[i].name +
                        '"><span class="glyphicon glyphicon-comment"></span></a></td></tr>';
                }
                row += ''
                $(row).appendTo("#rows");
            }, tk);

        })
    </script>
</body>

</html>