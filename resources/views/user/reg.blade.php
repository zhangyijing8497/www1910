<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>注册</title>
</head>
<body>
    <center>
        <h1>注册</h1>
        <form action="{{url('/user/reg')}}" method="post">
        <table>
            <tr>
                <td>用户名</td>
                <td><input type="text" name="user_name"></td>
            </tr>
            <tr>
                <td>邮箱</td>
                <td><input type="email" name="email"></td>
            </tr>
            <tr>
                <td>密码</td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td>确认密码</td>
                <td><input type="password" name="password2"></td>
            </tr>
            <tr>
                <td><input type="submit" value="注册"></td>
            </tr>
        </form>
        </table>
    </center>
</body>
</html>