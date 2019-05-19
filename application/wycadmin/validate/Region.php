<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/13
 * Time: 14:10
 */

namespace app\wycadmin\validate;


use think\Validate;

class Region extends Validate
{
    protected $rule = [
        ["title","require|max:32","名称不能为空|名称不能超过32个字符"],
        ["sort","require|between:0,127|integer","权限值不能为空|权限值只能填写0-127|权限值只能填写整数"],
        ["pid","require|egt:0|integer","上级id不能为空|上级id必须大于等于0|上级id必须为整数"],
    ];
}