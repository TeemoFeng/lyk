<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/22
 * Time: 9:36
 */

namespace app\wycadmin\validate;


use think\Validate;

class DirectpushReward extends Validate
{
    protected $rule = [
        ['dai','require|number',"赠送代数不能为空|赠送代数必须为数字"],
        ['bili','require|number',"赠送比例不能为空|赠送比例必须为数字"],
    ];

}