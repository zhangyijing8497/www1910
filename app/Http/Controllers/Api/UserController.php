<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\UserModel;
use App\Model\TokenModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    /**
     * 注册
     */
    public function reg(Request $request)
    {
        $post = $request->input();

        if(empty($post['user_name'])){
            $response = [
                'errno' => 50001,
                'msg'   => '用户名必填'
            ];
            return $response;
        }

        if(empty($post['email'])){
            $response = [
                'errno' => 50002,
                'msg'   => '邮箱必填'
            ];
            return $response;
        }

        if(empty($post['password'])){
            $response = [
                'errno' => 50003,
                'msg'   => '密码必填'
            ];
            return $response;
        }elseif(strlen($post['password'])<6){
            $response = [
                'errno' => 50004,
                'msg'   => '密码长度必须大于6位'
            ];
            return $response;
        }

        //验证确认密码
        if(empty($post['password2'])){
            $response = [
                'errno' => 50005,
                'msg'   => '确认密码必填'
            ];
            return $response;
        }else if ($post['password2'] != $post['password']){
            $response = [
                'errno' => 50006,
                'msg'   => '确认密码与密码不一致'
            ];
            return $response;
        }

        // 判断用户名,邮箱是否已经存在
        $u = UserModel::where(['user_name'=>$post['user_name']])->first();
        if($u){
            $response = [
                'errno' => 50007,
                'msg'   => '用户名已存在'
            ];
            return $response;
        }
        $u = UserModel::Where(['email'=>$post['email']])->first();
        if($u){
            $response = [
                'errno' => 50008,
                'msg'   => '邮箱已存在'
            ];
            return $response;
        }
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
            $response = [
                'errno' => 0,
                'msg'   => '注册成功'
            ];
            return $response;            
        }else{
            $response = [
                'errno' => 50009,
                'msg'   => '注册失败'
            ];
            return $response;
        }
    }

    /**
     * 登陆
     */
    public function login(Request $request)
    {
        $u = $request->input('u');
        $pwd = $request->input('password');
        $res = UserModel::where(['user_name'=>$u])->orWhere(['email'=>$u])->first();
        if($res == NULL){
            echo '用户不存在,请先注册用户!';
        }

        $res2 = password_verify($pwd,$res->password);
        if($res2){
            UserModel::where(['user_name'=>$u])->update(array(
                'last_login'=>time(),
                'last_ip'   =>$_SERVER['REMOTE_ADDR']
            ));
           //生成token
           $str = $res->user_id . $res->user_name . time();
           $token = substr(md5($str),10,16);
           $data = [
               'uid'    => $res->user_id,
               'token'  => $token
           ];
           TokenModel::insertGetId($data);
           $response = [
            'errno'     => 0,
            'msg'       => 'ok',
            'token'     => $token
           ];
           return $response;
        }else{
            $response = [
                'errno'     => 50010,
                'msg'       => '用户名与密码不一致'
            ];
            return $response;
        } 
    }

    /**
     * 个人中心
     */
    public function center()
    {
        $token = $_GET['token'];
        $res = TokenModel::where(['token'=>$token])->first();
        //    dd($res);
        if($res){
            $uid = $res->uid;
            $userInfo = UserModel::find($uid);
            echo "欢迎".$userInfo->user_name."来到个人中心";
        }else{
            echo "请先登陆!!";
        }
    }
}
