<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/28
 * Time: 9:21
 */

namespace app\api\controller;

use app\common\controller\Base;
use think\Cookie;

class Code extends Base
{

     private $zhuce = 62300;
    private $wangjimima = 62309;
    private $ali = 57656;
  	private $pipei = 62282;
  	private $admin = 62318;

    // 二维码
    public function qrcode()
    {
        $savePath = APP_PATH . '/../Public/qrcode/';
        $webPath = '/qrcode/';
        $qrData = 'http://www.acn888.com/nickbai/';
        $qrLevel = 'H';
        $qrSize = '8';
        $savePrefix = 'NickBai';

        if($filename = $this->createQRcode($savePath, $qrData, $qrLevel, $qrSize, $savePrefix)){
            $pic = $webPath . $filename;
        }
        echo "<img src='".$pic."'>";
    }

    //短信
    public function getSms(){
        if(!request()->isPost()){
            $this->error('当前请求非法！');
        }
        $data = input('post.');
        if($data['type'] == 'admin'){
            $data['mobile'] = 13357955920;
          //	$data['mobile'] = 13503867375;
        }
        $this->validateCheck ('Mobile',$data);
        //判断是否超过验证码有效期
        if(Cookie::has($data['type'])){
            if(time() - cookie($data['type'].'_start_time') < 300){
                return $this->error ('验证码5分钟内有效');
            }else{
                cookie($data['type'],null);
            }
        }
        //判断是忘记密码还是注册账户
        if($data['type'] == 'forget'){
            $result = model ('Member')->where ('mobile',$data['mobile'])->where ('status',$this->normal)->find ();
            if($result){
                return $this->sendSms($data['mobile'],$this->wangjimima,$data['type']);
            }else{
                return $this->error ('该手机号未注册,或以封禁');
            }
        }
        if($data['type'] == 'register'){
            if(!captcha_check ($data['yanzheng'])){
                $this->error('图形验证码错误');
            }
            $result = $this->checkMember ($data['mobile']);
            if($result){
               return $this->error('该手机号已注册','index/login/forgetpassword');
            }{
                return $this->sendSms($data['mobile'],$this->zhuce,$data['type']);
            }
        }
        if($data['type'] == 'updateali'){
            $info = model ('Member')->where ('mobile',$data['mobile'])->value ('id');
            if (!$info){
                return $this->error ('未知错误');
            }
            $bankinfo = model ('Bank')->where ('uid',$info)->find ();
            if ($bankinfo->ali == ''){
                return $this->error ('实名认证后,才能修改','index/member/membershiming');
            }
            return $this->sendSms($data['mobile'],$this->ali,$data['type']);
        }
        if($data['type'] == 'admin'){
            return $this->sendSms($data['mobile'],$this->ali,$data['type']);
        }
    }

    //发送验证码
    public function sendSms($mobile,$typeCode,$type){
        $code = rand(1000,9999);
        cookie($type,serialize(['code'=>$code,'mobile'=>$mobile]));
        cookie($type.'_start_time',time());
      	$params = array(
            'Account'=>'15000000001',
            'Pwd'=>'7b755237e2c9557ce34e35195',
            'Content'=>$code,
            'Mobile'    => $mobile, //接受短信的用户手机号码
            'TemplateId'    => $typeCode, //您申请的短信模板ID，根据实际情况修改
            'SignId' =>115086 //您设置的模板变量，根据实际情况修改
        );
        $paramstring = http_build_query($params);
        $content = $this->juheCurl('http://api.feige.ee/SmsService/Template', $paramstring, 1);
        if($content){
            $result = json_decode($content, true);
            $error_code = $result['Code'];
            if($error_code == 0){
                return $this->error('短信发送成功');
                //状态为0，说明短信发送成功
               // return true;//$this->error('短信发送成功');
            }else{
                //状态非0，说明失败
               $msg = $result['Message'];
                return $this->error ($msg);
            }
        }else{
             return json(array('bools'=>false,'msg'=>'短信已发送，未收到请重试'));
        }
    }
  
  
  //发送验证码
    public function sendSms1($mobile = 0){
      $params = array(
            'Account'=>'15000000001',
            'Pwd'=>'7b755237e2c9557ce34e35195',
            'Content'=>'',
            'Mobile'    => $mobile, //接受短信的用户手机号码
            'TemplateId'    => $this->pipei, //您申请的短信模板ID，根据实际情况修改
            'SignId' =>115086 //您设置的模板变量，根据实际情况修改
        );
        $paramstring = http_build_query($params);
        $content = $this->juheCurl('http://api.feige.ee/SmsService/Template', $paramstring, 1);
        if($content){
            $result = json_decode($content, true);
            $error_code = $result['Code'];
            if($error_code == 0){
                return true;
                //状态为0，说明短信发送成功
               // return true;//$this->error('短信发送成功');
            }else{
                //状态非0，说明失败
               return false;
            }
        }else{
            return false;
        }
    }


    public function checkMember($mobile){
        return model ('Member')->where ('mobile',$mobile)->where ('status','neq',-1)->find ();
    }

    private function juhecurl($url,$params=false,$ispost=0){
        $httpInfo = array();
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        if( $ispost )
        {
            curl_setopt( $ch , CURLOPT_POST , true );
            curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
            curl_setopt( $ch , CURLOPT_URL , $url );
        }
        else
        {
            if($params){
                curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
            }else{
                curl_setopt( $ch , CURLOPT_URL , $url);
            }
        }
        $response = curl_exec( $ch );
        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
        $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
        curl_close( $ch );
        return $response;
    }

}