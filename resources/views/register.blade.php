<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register</title>

    @include('block.head')
</head>

<body>
    <div class="center">
        @include('block.header')
        @include('block.msgbar')
        <form>
            <input type="hidden" id="token" value="{{$token}}" />
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Name">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="email" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="exampleInputRole1">Role</label>
                <select class="form-control" id="role" placeholder="Role">
                    @foreach($role as $k=>$v)
                    <option value="{{$k}}">{{$v}}</option>
                    @endforeach
                </select>
            </div>
            <button type="button" id="submit" class="btn btn-default">Register</button>
        </form>
    </div>
    <script type="text/javascript">
        $(function() {

            $("#submit").on('click', function() {
                var data = {
                    'name': $("#name").val(),
                    'email': $("#email").val(),
                    'password': $("#password").val(),
                    'role': $('#role').val(),
                    'token': $("#token").val()
                };
                request('/api/register', 'post', data, function(data) {
                    localStorage.setItem('token', JSON.stringify(data.token));
                    alert('登录成功');
                    window.location.href = '/';
                })
            })

        })
    </script>
</body>

</html>