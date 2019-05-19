<?php
/**
 * Created by PhpStorm.
 * User: aa
 * Date: 2019/1/17
 * Time: 21:36
 */

namespace app\wycadmin\validate;


use think\Validate;

class Category extends Validate
{
    protected $rule = [
        ["title","require|max:32","标题不能为空|标题不能超过32个字符"],
        ["content","max:128","介绍最长128个字符"],
        ['display_type', 'require|in:1,2|integer', '请选择显示类型|显示类型value 1or2|显示类型只能为整数'],
        ["sort","require|between:0,127|integer","权限值不能为空|权限值只能填写0-127|权限值只能填写整数"],
        ["cid","require|egt:0|integer","类型不能为空|类型id必须大于等于0|类型id必须为整数"],
    ];
}