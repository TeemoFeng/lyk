<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/17
 * Time: 14:37
 */
namespace app\wycadmin\validate;

use think\Validate;

class Member extends Validate{
    protected $rule = [
        ['number','require|unique:Member|max:20','编号不能为空|该编号已存在|编号最长20位'],
        ['mobile','require|unique:Member|max:11|/^1[3-9]{1}[0-9]{9}$/','请输入手机号码|该号码已注册|手机号码最多不能超过11个字符|手机号码格式不正确'],
        //['refereeCode','require','推荐人邀请码不能为空'],
        ['password','require|max:12|min:6|confirm',"密码不能为空|密码最长12位|密码最短6位|两次输入的密码不一致"],
        ['spassword','require|max:12|min:6|confirm',"安全密码不能为空|安全密码最长12位|安全密码最短6位|两次输入的安全密码不一致"],
    ];
}