<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/13
 * Time: 15:21
 */

namespace app\wycadmin\validate;


use think\Validate;

class Vehicle extends Validate
{
    protected $rule = [
        ["title","require|max:16","交通工具名不能为空|交通工具名不能超过16个字符"],
    ];
}