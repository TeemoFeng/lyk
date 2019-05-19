<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/17
 * Time: 17:13
 */

namespace app\h5\validate;


use think\Validate;

class CardActive0 extends Validate
{
    protected $rule = [
        ['name', 'require|max:8', '姓名不能为空|姓名最长8个字'],
        ['mobile','require|max:11|/^1[3-9]{1}[0-9]{9}$/|unique:member','请输入手机号码|手机号码最多不能超过11个字符|手机号码格式不正确|该手机号已注册'],
        ['name_id', 'require|max:25|min:15', '身份证号不能为空|身份证号最长25位|身份证号最短15位'],
        ['addr', 'require|max:128', '所在省市县不能为空|所在省市县不能大于128字'],
        ['xiangxi', 'require|max:128', '详细住址不能为空|详细住址不能大于128字'],
    ];
}