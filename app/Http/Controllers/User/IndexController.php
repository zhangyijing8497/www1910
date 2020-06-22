<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\IndexModel;

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
        $u = IndexModel::where(['user_name'=>$post['user_name']])->orWhere(['email'=>$post['email']])->first();
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

            $uid = IndexModel::insertGetId($userInfo);
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

    public function loginDo()
    {

    }
}
