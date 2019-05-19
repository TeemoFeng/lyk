<?php

/**
 * 微信网页授权 -- 控制器
 */
namespace app\h5\controller;

use think\Request;

class WeChat extends Base
{
    public static $appid = '你的AppID';
    public static $secret = "你的AppSecret";
    public static $scope = 'snsapi_userinfo'; //授权作用域
    public static $redirect_url = '域名/getUserInfo'; //回调地址

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        self::getCode();
    }

    /**
     * 获取微信返回的code码
     * @auther enfu
     * @date 2019/5/14 10:25
     */
    public static function getCode()
    {
        //回调地址
        $redirect_url = urlencode(self::$redirect_url);
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.self::$appid.'&redirect_uri='.$redirect_url.'&response_type=code&scope='.self::$scope.'&state=STATE#wechat_redirect';
        header("Location:".$url);
    }

    /**
     *  拉取微信用户信息
     */
    public static function getUserInfo()
    {
        //1.取得openid
        $code = request()->get('code'); //获取code码
        $oauth2Url  = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.self::$appid.'&secret='.self::$secret.'&code='.$code.'&grant_type=authorization_code';
        $oauth2 = self::getJson($oauth2Url);

        if($oauth2['errcode'] == 0){
            //2. 根据全局access_token和openid查询用户信息
            $getUserInfoUrl  = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$oauth2['access_token'].'&openid='.$oauth2['openid'].'&lang=zh_CN';
            //3. 打印用户信息
            $userinfo = self::getJson($getUserInfoUrl);
            dump($userinfo);
        }

        // return $userinfo;
    }

    /**
     * curl get方法
     * @param $url
     * @return mixed
     * @auther enfu
     * @date 2019/5/14 10:48
     */
    public static function getJson($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, true);
    }
}