<?php
/**
 * Created by PhpStorm.
 * User: aa
 * Date: 2019/1/17
 * Time: 21:36
 */

namespace app\wycadmin\validate;


use think\Validate;

class Level extends Validate
{
    protected $rule = [
        ["title","require|max:12","等级名称不能为空|等级名称不能超过12个字符"],
        ["level_number","require|number","关联数字不能为空|关联数字只能填写数字"],
        ["buy_price","require|number","投资需求不能为空|投资需求必须填写数字"],
        ["give_price","require|number","投资赠送不能为空|投资赠送只能填写数字"],
        ["dsj_wallet","require|number","大数据钱包不能为空|大数据钱包只能填写数字"],
    ];
}