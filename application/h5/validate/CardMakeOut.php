<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/16
 * Time: 16:44
 */

namespace app\h5\validate;


use think\Validate;

class CardMakeOut extends Validate
{
    protected $rule = [
        ['card_id','require|gt:0|integer','请选择转出卡类|非法操作|非法操作'],
        ['id','require|gt:0|integer','请选择要转出的卡|非法操作|非法操作'],
        ['put_mobile','require|/^1[3-9]{1}[0-9]{9}$/','收卡人手机号不能为空|收卡人手机号码格式不正确'],
    ];
}