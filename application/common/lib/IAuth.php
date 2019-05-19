<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/17
 * Time: 15:23
 */

namespace app\common\lib;


class IAuth
{
    /**
     * @param $data
     * 设置密码
     */
    public static function setPassword($data){
       return md5 ($data.config ('app.password_pre_halt'));
    }

    public static function setStatus($data){
        if (!isset($data['status'])){
            $data['status'] = 0;
        }
        return $data;
    }
}