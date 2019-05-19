<?php
/**
 * Created by PhpStorm.
 * User: aa
 * Date: 2019/1/19
 * Time: 16:35
 */

namespace app\wycadmin\validate;


use think\Validate;

class Power extends Validate
{
    protected $rule = [
        ["title","require|max:20","权限名不能为空|权限名不能超过20个字符"],
    ];
}