<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/10
 * Time: 14:10
 */

namespace app\wycadmin\validate;


use think\Validate;

class Zjhz extends Validate
{
    protected $rule = [
        ["title","require|max:12","转换类型介绍不能为空"],
        ["bili","require|number","币种2比例不能为空|币种2比例只能填写数字"],
        ["shouxu","require|number","手续费不能为空|手续费必须填写数字"],
    ];
}