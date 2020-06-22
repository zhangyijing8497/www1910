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
            用 户 名 : <input type="text" name="user_name"><br>
            密    码 : <input type="password" name="password"><br>
            <input type="submit" value="登陆">
        </form>
    </center>
</body>
</html>