<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/5
 * Time: 9:35
 */

namespace app\api\validate;


use think\Validate;

class Mobile extends Validate
{
    protected $rule = [
        ['mobile','require|/^1[3-9]{1}[0-9]{9}$/','手机号不能为空|手机号码格式不正确'],
    ];
}