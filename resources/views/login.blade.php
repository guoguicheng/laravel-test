<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

    @include('block.head')
</head>

<body>
    <div class="center">
        @include('block.header')
        <form>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="email" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <button type="button" id="submit" class="btn btn-default">Login</button>
        </form>
    </div>
    <script type="text/javascript">
        $(function() {

            $("#submit").on('click', function() {
                var data = {
                    'grant_type': 'password',
                    'username': $("#email").val(),
                    'password': $("#password").val(),
                    'client_id': 5,
                    'client_secret': 'YwJ1pjaj3TxWR5NwfoIiL3y3tO7kbsti7fpE6Oj9',
                    'scope': '*'
                };
                request('/oauth/token', 'post', data, function(data) {
                    localStorage.setItem('token', JSON.stringify(data));
                    alert('登录成功');
                    window.location.href = '/';
                })
            })

        })
    </script>
</body>

</html>