<?php
/**
 * Created by PhpStorm.
 * User: 唐懿德
 * Date: 2019/5/15
 * Time: 22:17
 */

namespace app\h5\validate;


use think\Validate;

class BuyCard extends Validate
{
    protected $rule = [
        ['id','require|gt:0|integer','卡片编号不能为空|卡片编号必须大于0|卡片编号只能为整数'],
        ['num','require|gt:0|integer','购买数量不能为空|购买数量必须大于0|购买数量只能为整数'],
    ];
}