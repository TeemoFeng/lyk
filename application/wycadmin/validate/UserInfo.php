<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/17
 * Time: 14:37
 */
namespace app\wycadmin\validate;

use think\Validate;

class UserInfo extends Validate{
    protected $rule = [
        ['mobile','require|max:11|/^1[3-9]{1}[0-9]{9}$/','请输入手机号码|手机号码最多不能超过11个字符|手机号码格式不正确'],
        ['bank_number','require|max:20',"银行卡号不能为空|银行卡号最长20位"],
        ['bank_name','require',"开户行不能为空"],
        ['name','require',"开户人姓名不能为空"],
        ['bank_addr','require',"开户行地址不能为空"],
        ['usdt','require',"usdt账号不能为空"],
        ['ali','require',"支付宝账号不能为空"],
    ];
}