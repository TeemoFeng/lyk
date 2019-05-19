<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/17
 * Time: 14:37
 */
namespace app\wycadmin\validate;

use think\Validate;

class AdminUser extends Validate{
    protected $rule = [
        ['username','require|max:20|min:6|unique:AdminUser',"管理员名不能为空|用户名最长20位|管理员名最短6位|管理员名已存在"],
        ['password','require|max:20|min:6|confirm',"密码不能为空|密码最长20位|密码最短6位|两次输入的密码不一致"],
    ];
}