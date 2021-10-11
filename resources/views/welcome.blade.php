<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    @include('block.head')
</head>

<body>
    <div class="center">
        @include('block.header')

        <h2>当前登录用户：</h2>
        <h1 id="uname">未登录</h1>
    </div>
    <script type="text/javascript">
        $(function() {
            var token = JSON.parse(localStorage.getItem('token'));
            var tk = token.token_type + ' ' + token.access_token;
            var data = {};
            request('/api/user', 'get', data, function(data) {
                $("#uname").html(data.id + '|' + data.name + '|' + data.email);
            }, tk);

        })
    </script>
</body>

</html>