<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>baimaokaoyan | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="/adminlte/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/login.css">

</head>
<body class="hold-transition login-page">
<div class="dmaku-container">

    <div class="demo form-bg" style="padding: 20px 0;">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <form class="form-horizontal" action="/admin/login" method="post">
                        {{ csrf_field() }}
                        <span class="heading">白猫考研管理后台</span>
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="用户名">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="form-group help">
                            <input type="password" class="form-control" id="password" name="password" placeholder="密　码">
                            <i class="fa fa-lock"></i>
                            <a href="#" class="fa fa-question-circle"></a>
                        </div>
                        @include("admin.layout.error")
                        <div class="form-group">
                            <div class="main-checkbox">
                                <input type="checkbox" value="None" id="checkbox1" name="check"/>
                                <label for="checkbox1"></label>
                            </div>
                            <span class="text">Remember me</span>
                            <button type="submit" class="btn btn-default">登录</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- jQuery 2.2.3 -->
<script src="/adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/adminlte/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
