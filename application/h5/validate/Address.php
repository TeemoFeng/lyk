<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/6
 * Time: 14:58
 */

namespace app\h5\validate;


use think\Validate;

class Address extends Validate
{
    protected $rule = [
        ['name','require|max:8','姓名不能为空|姓名最长8字'],
        ['mobile','require|max:11|/^1[3-9]{1}[0-9]{9}$/','请输入手机号码|手机号码最多不能超过11个字符|手机号码格式不正确'],
        ['addr','require|max:48',"省市区不能为空|省市区最长48字"],
        ['xiangxi','require|max:72',"详细地址不能为空|详细地址最长72字"],
    ];
}