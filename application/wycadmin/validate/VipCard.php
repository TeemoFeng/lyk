<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/14
 * Time: 14:16
 */

namespace app\wycadmin\validate;


use think\Validate;

class VipCard extends Validate
{
    protected $rule = [
        ['title', 'require|max:32', '卡片名称不能为空|卡片名称不能大于32字'],
        ['id', 'require|between:1,127|integer', '卡片ID不能为空|卡片ID只能填写1-127|卡片id只能填写整数'],
        ['price', 'require|number|between:0,99999999', '卡片价格不能为空|卡片价格只能为数字|卡片价格只能填写0-99999999'],
        ['card_type', 'require|in:1,2|integer', '请选择卡片类型|卡片类型value只能为1or2|卡片类型value只能为整数'],
        ['card_type_number', 'require|between:1,99999|integer', '使用次数或到期天数不能为空|使用次数或到期天数只能填写1-99999|使用次数或到期天数只能填写整数'],
        ['recommend_award_type', 'require|in:1,2,3,4|integer', '请选择直推奖励方案|直推奖励方案类型value只能为1or2or3or4|直推奖励方案类型value只能为整数'],
        ['recommend_award_price_up', 'require|number|between:0,99999999', '线上购买激活奖金不能为空|线上购买激活奖金只能为数字|线上购买激活奖金只能填写0-99999999'],
        ['recommend_award_price_down', 'require|number|between:0,99999999', '线上购买激活奖金不能为空|线上购买激活奖金只能为数字|线上购买激活奖金只能填写0-99999999'],
        ['open', 'require|in:0,1|integer', '请选择是否开启分销|分销开关value只能为0or1|分销开关value只能为整数'],
        ['introduce', 'require|max:255', '卡片介绍不能为空|卡片介绍最长255字'],
        ['strategy', 'require|max:255', '卡片攻略不能为空|卡片攻略最长255字'],
    ];
}