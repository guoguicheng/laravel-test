<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>关注列表</title>

    @include('block.head')
</head>

<body>
    <div class="center">
        @include('block.header')
        <table class="table">
            <caption>学生列表</caption>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>学生姓名</th>
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
            request('/api/teacher/follow/list', 'get', data, function(data) {
                console.log(data);
                var row = '';
                for (var i = 0; i < data.length; i++) {
                    row += '<tr><td>' + data[i].id + '</td><td>' + data[i].student_info.name + '</td></tr>';
                }
                $(row).appendTo("#rows");
            }, tk);

        })
    </script>
</body>

</html>