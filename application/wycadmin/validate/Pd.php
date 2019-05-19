<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/29
 * Time: 17:11
 */

namespace app\wycadmin\validate;


use think\Validate;

class Pd extends Validate
{
    protected $rule = [
        ["pid","require|integer","分类id不能为空|分类id只能填写整数"],
        ["title","require|max:16","请填写标题|标题最长16字"],
        ["content","require|max:16","请填写简介|详细最长16字"],
        ["type","require","请选择对应显示区域"],
    ];
}