<?php
/**
 * Created by PhpStorm.
 * User: aa
 * Date: 2019/1/17
 * Time: 21:36
 */

namespace app\wycadmin\validate;


use think\Validate;

class Banner extends Validate
{
    protected $rule = [
        ["sc_id","require|integer|gt:0","景区编号不能为空|景区编号只能填写整数|景区编号必须大于0"],
    ];
}