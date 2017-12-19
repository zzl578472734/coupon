<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <title>Fullscreen Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="{{ asset('css/admin/supersized.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/login.css') }}">
</head>
<body>

<div class="page-container">
    <h1>Hi！轮子</h1>
    <div class='form'>
        {{ csrf_field() }}
        <input type="text" name="username" id="username" placeholder="请输入账号" value='zzl578472734' />
        <input type="password" name="password" id="password" placeholder="请输入密码" value='zzl239131' />
        <button id='login'>登陆</button>
        <div class="error"><span>+</span></div>
     </div>
    <div class="connect">
        <p>床前明月光，疑似地上霜</p>
    </div>
</div>

<script src="{{ asset('js/jquery-1.8.2.min.js') }}"></script>
<script src="{{ asset('js/jquery.cookie.js') }}"></script>
<script src="{{ asset('js/admin/supersized.3.2.7.min.js') }}"></script>
<script src="{{ asset('js/admin/supersized-init.js') }}"></script>
<script src="{{ asset('js/admin/login.js') }}"></script>
</body>
</html>

