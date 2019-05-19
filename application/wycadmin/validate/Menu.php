<?php
/**
 * Created by PhpStorm.
 * User: aa
 * Date: 2019/1/17
 * Time: 21:36
 */

namespace app\wycadmin\validate;


use think\Validate;

class Menu extends Validate
{
    protected $rule = [
            ["title","require|max:20","菜单名不能为空|菜单名不能超过20个字符"],
            ["controller","require|max:20","控制器名不能为空|控制器名不能超过20个字符"],
            ["action","require|max:20","方法名不能为空|方法名不能超过20个字符"],
            ["sort","number","排序必须为数字"],
    ];
}