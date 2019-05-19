<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/17
 * Time: 17:36
 */

namespace app\h5\validate;


use think\Validate;

class CardActive3 extends Validate
{
    protected $rule = [
        ['pmobile','require|max:11|/^1[3-9]{1}[0-9]{9}$/','请输入推荐人手机号码|荐人手机号码最多不能超过11个字符|荐人手机号码格式不正确'],
    ];
}