<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>个人中心</title>
</head>
<body>
    <center>
        <h2>个人中心</h2>
        欢迎<span style="color:red">{{$_COOKIE['name']}}</span>回来<br>
        <table>
            <tr>
                <td>用户名</td>
                <td>{{$u['user_name']}}</td>
            </tr>
            <tr>
                <td>邮箱</td>
                <td>{{$u['email']}}</td>
            </tr>
            <tr>
                <td>注册时间</td>
                <td>{{date('Y-m-d H:i:s',$u['reg_time'])}}</td>
            </tr>
            <tr>
                <td>最后登录时间</td>
                <td>{{date('Y-m-d H:i:s',$u['last_login'])}}</td>
            </tr>
        </table>
    </center>
</body>
</html>