<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登陆</title>
</head>
<body>
    <center>
        <h1>登陆</h1>
        <form action="{{url('/user/login')}}" method="post">
            <table>
                <tr>
                    <td>用户名</td>
                    <td><input type="text" name="u" placeholder="用户名\邮箱"></td>
                </tr>
                <tr>
                    <td>密码</td>
                    <td><input type="password" name="password" placeholder="密码"></td>
                </tr>
                <tr>
                    <td><input type="submit" value="登陆"></td>
                </tr>
            </table>
        </form>
    </center>
</body>
</html>