<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/17
 * Time: 17:13
 */

namespace app\h5\validate;


use think\Validate;

class CardActive2 extends Validate
{
    protected $rule = [
        ['card_id', 'require|gt:0|integer', '请选择激活的卡类型|卡类型参数错误|卡类型参数错误'],
        ['card_number', 'require|max:32', '卡号不能为空|卡号最长32位'],
    ];
}