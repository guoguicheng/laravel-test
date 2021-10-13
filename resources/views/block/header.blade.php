<hr />
<div class="links">
    <a href="/teacheralllist">关注老师</a>
    <a href="/teacherlist">老师列表</a>
    <a href="/stulist">学生列表</a>
    <a href="/followlist">关注学生</a>
    <a href="/login" class="login">登录</a>
    <a href="/register" class="register">注册</a>
    <a href="javascript:void(0)" class="hide logout">退出登录</a>
</div>
<hr />
<script>
    $(function() {
        checkLogin();

        $(".logout").on('click', function() {
            localStorage.removeItem('token');
            $(".login,.register").removeClass('hide');
            $(".logout").addClass('hide');
        });

        function checkLogin() {
            var tokenStr = localStorage.getItem('token');
            if (!tokenStr) {
                $(".login,.register").removeClass('hide');
                $(".logout").addClass('hide');
            } else {
                $(".login,.register").addClass('hide');
                $(".logout").removeClass('hide');
            }
        }

    })
</script>