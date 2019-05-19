<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/13
 * Time: 13:40
 */

namespace app\wycadmin\validate;


use think\Validate;

class UserBanner extends Validate
{
    protected $rule = [
        ["title","require","备注不能为空"],
    ];
}