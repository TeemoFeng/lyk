<?php

/**
 * 基础公共--控制器
 */
namespace app\h5\controller;


use app\h5\model\Member;
use app\h5\model\WxLogin;
use think\Controller;
use think\Db;
use think\Exception;
use think\Log;
use think\Request;

class Base extends Controller
{
    public $url = '域名';
    public $userId = 1;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
session('user_id', 2);
        if(session('user_id')){
            $this->userId = session('user_id');
            $this->userInfo = Member::getInfo ([
                'id'=>$this->userId
            ]);
        }else{
            if(self::isWechatAccess())
            {
                self::saveWechatUser();
            } else {
                header('Location:'.$this->url);
            };
        }


    }

    /**
     * 判断是否是微信内部访问
     * @return bool
     * @auther enfu
     * @date 2019/5/14 11:21
     */
    protected static function isWechatAccess()
    {
        return true;
    }


    protected function validateCheck($validateName,$data){
        $validate = validate($validateName);
        if (!$validate->check($data)){
           \exception ($validate->getError ());
        }
    }

    /**
     * 微信登陆成功保存用户信息
     * @auther enfu
     * @date 2019/5/14 11:22
     */
    public static function saveWechatUserInfo()
    {

        // 1. 获取微信用户信息
        $userInfo = WeChat::getUserInfo();
        Db::startTrans();
        try{
            if($userInfo){
                //2.写入数据库 wx_login 表
                WxLogin::saveUserInfo($userInfo);
            }
            Db::commit();
        } catch ( Exception $e) {

            Db::rollback();
            log::write('保存微信用户失败:'.$e->getMessage(),'error');
            return false;
        }
      return true;
    }

    public static function saveWechatUser()
    {
        try{
            $wchat = new \wechat\WechatOauth();
            $code = request()->param('code',"");
            $user = $wchat->getUserAccessUserInfo($code);
            if($user){
                //查看用户是否存在
                $member = new Member();
                if(!isset($user['id'])){
                    //添加用户信息
                    $data['username'] = $user['nickname'];
                    $data['password'] = '123456';
                    $data['s_password'] = '123456';
                    $data['wx_header_image'] = $user['headimgurl'];
                    $data['openid'] = $user['openid'];
                    $data['create_time'] = time();
                    $data['last_login_time'] = time();
                    $res = $member->add($data);
                    if($res == false){
                        exception ('授权失败');
                    }
                    session('user_id', $res);
                    session('openid', $user['openid']);
                }

            }else{
                exception ('请先授权登录');
            }
        }catch (Exception $e){
            echo $e->getMessage ();
        }

    }

}