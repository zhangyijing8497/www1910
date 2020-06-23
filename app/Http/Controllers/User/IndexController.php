<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserModel;

class IndexController extends Controller
{
    /**
     * 注册视图
     */
    public function reg()
    {
        return view('user.reg');
    }

    public function regDo(Request $request)
    {
        $post = $request->input();

        if(empty($post['user_name'])){
            echo "<script>alert('用户名必填');window.history.go(-1);</script>";
            die;
        }

        if(empty($post['email'])){
            echo "<script>alert('邮箱必填');window.history.go(-1);</script>";
            die;
        }

        if(empty($post['password'])){
            echo "<script>alert('密码必填');window.history.go(-1);</script>";
            die;
        }elseif(strlen($post['password'])<6){
            echo "<script>alert('密码长度必须大于6位');window.history.go(-1);</script>";
            die;
        }

        //验证确认密码
        if(empty($post['password2'])){
            echo "<script>alert('确认密码必填');window.history.go(-1);</script>";
            die;
        }else if ($post['password2'] != $post['password']){
            echo "<script>alert('确认密码与密码不一致');window.history.go(-1);</script>";
            die;
        }

        // 判断用户名,邮箱是否已经存在
        $u = UserModel::where(['user_name'=>$post['user_name']])->orWhere(['email'=>$post['email']])->first();
        if($u==NULL){
            //密码加密
            $pwd = password_hash($post['password'],PASSWORD_BCRYPT);

            //数据入库
            $userInfo = [
                'user_name'  => $post['user_name'],
                'email'     => $post['email'],
                'password'      => $pwd,
                'reg_time'      => time()
            ];

            $uid = UserModel::insertGetId($userInfo);
            if($uid>0){
                echo "<script>alert('注册成功',location='/user/login')</script>";
            }else{
                echo "<script>alert('注册失败',location='/user/reg')</script>";
            }
        }else{
            echo "<script>alert('该用户已存在');window.history.go(-1);</script>";
            die;
        }
    }

    /**
     * 登陆视图
     */
    public function login()
    {
        return view('user.login');
    }

    public function loginDo(Request $request)
    {
        $u = $request->input('u');
        $pwd = $request->input('password');
        $res = UserModel::where(['user_name'=>$u])->orWhere(['email'=>$u])->first();
        if($res == NULL){
            echo "<script>alert('用户不存在,请先注册用户!');location='/user/reg'</script>";
        }

        if(!password_verify($pwd,$res->password)){
            echo "<script>alert('密码不正确,请重新输入..'); window.history.back(-1); </script>";
            die;
        }
        UserModel::where(['user_name'=>$u])->update(array(
            'last_login'=>time(),
            'last_ip'   =>$_SERVER['REMOTE_ADDR']
        ));
        setcookie('uid',$res->user_id,time()+3600,'/');
        setcookie('name',$res->user_name,time()+3600,'/');
        echo "<script>alert('登陆成功,正在跳转至个人中心');location='/user/center'</script>";

    }

    /**
     * 个人中心
     */
    public function center()
    {
        // echo '<pre>';print_r($_COOKIE);echo '</pre>';
        $uid = $_COOKIE['uid'];
        $u = UserModel::where(['user_id'=>$uid])->first();

        if(isset($_COOKIE['uid']) && isset($_COOKIE['name'])){
            return view('user.center',['u'=>$u]);
        }else{
            echo "<script>alert('请先登录!!!');location='/user/login'</script>";
        }        
    }
}
