<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * 签名测试  发送端
     */
    public function sign1()
    {
        $key = 'bdsksjdalvbvakfa';
        $data = 'hello php';
        $sign = sha1($data.$key);

        echo "要发送的数据: ".$data;echo "</br>";
        echo "发送前生成的签名: ".$sign;echo "<hr>";

        $uri = "http://www.1910.com/secret?data=".$data."&sign=".$sign;
        echo  $uri;
    }

    /**
     * 接收数据
     */
    public function secret()
    {
        $key = 'bdsksjdalvbvakfa';
        echo '<pre>';print_r($_GET);echo '</pre>';
        //收到数据  验证签名
        $data = $_GET['data'];
        $sign = $_GET['sign'];
        
        // 验证签名
        $local_sign = sha1($data.$key);
        echo "本地计算的签名: ".$local_sign;echo "</br>";

        if($sign == $local_sign){
            echo "验签通过";
        }else{
            echo "验签失败";
        }
    }

    public function www()
    {
        $key = 'sjbvbvkvkcbs';
        $url = 'http://api.1910.com/api/info';
        
        //向API发送数据
        $data = 'hi';
        $sign = sha1($data.$key);
        echo "发送端计算的签名: ".$sign;echo "</br>";

        $url = $url . '?data=' . $data . '&sign=' .$sign;

        // 发起网络请求
        $response = file_get_contents($url);
        echo $response;
    }

    /**
     * 请求接口
     */
    public function sendData()
    {
        $url = 'http://api.1910.com/test/receive?uname=smile&age=13';
        $response = file_get_contents($url);
        echo $response;
    }

    /**
     * 向接口 post 数据
     */
    public function postData()
    {
        $data = [
            'user_name' => 'zhnagsan',
            'user_age'  => 13
        ];
        $url = 'http://api.1910.com/test/receive-post';

        // 使用curl post数据数据
        // 1 实例化
        $ch = curl_init();
        // 2 配置参数
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        // 3 开启会议
        $response = curl_exec($ch);

        // 4 检测错误
        $errno = $err = curl_errno($ch);
        $errmsg = curl_errno($ch);

        if($errno){
            var_dump($errmsg);
            die;
        }
        curl_close($ch);
        echo $response;
    }

    /**
     * 对称加密
     */
    public function encrypt1()
    {
        $data = '好久不见';
        $method = 'AES-256-CBC';
        $key = 'sjvgkavobava';
        $iv = '1910aslkdjhfzxcv';
        echo "原数据: " .$data;echo "</br>";

        // 加密
        $enc_data = openssl_encrypt($data,$method,$key,OPENSSL_RAW_DATA,$iv);
        echo "加密后的数据: " . $enc_data;echo "<hr>";

        $sign = sha1($enc_data.$key);  //签名

        $post_data = [
            'data'  => $enc_data,
            'sign'  => $sign
        ];

        // 使用curl post数据数据
        $url = 'http://api.1910.com/test/decrypt1';

        // 1 实例化
        $ch = curl_init();
        // 2 配置参数
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        // 3 开启会议
        $response = curl_exec($ch);

        // 4 检测错误
        $errno = $err = curl_errno($ch);
        $errmsg = curl_errno($ch);

        if($errno){
            var_dump($errmsg);
            die;
        }
        curl_close($ch);
        echo $response;
    }

    /**
     * 非对称加密
     */
    public function rsaEncrypt1()
    {
        $data = '左手握大地,右手握着天';


        // 使用公钥加密
        $key_content = file_get_contents(storage_path('keys/pub.key'));
        $pub_key = openssl_get_publickey($key_content);
        openssl_public_encrypt($data,$enc_data,$pub_key);
        echo "加密后:" . $enc_data;echo "</br>";

        $post_data = [
            'data'  => $enc_data,
        ];

        // 使用curl post数据数据
        $url = 'http://api.1910.com/rsa/decrypt1';

        // 1 实例化
        $ch = curl_init();
        // 2 配置参数
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        // 3 开启会议
        $response = curl_exec($ch);

        // 4 检测错误
        $errno = $err = curl_errno($ch);
        $errmsg = curl_errno($ch);

        if($errno){
            var_dump($errmsg);
            die;
        }
        curl_close($ch);
        echo $response;
    }
}
