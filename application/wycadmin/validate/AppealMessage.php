<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/24
 * Time: 10:20
 */

namespace app\wycadmin\validate;


use think\Validate;

class AppealMessage extends Validate
{
    protected $rule = [
        ['obj','require','请选发送对象'],
        ['content','require|max:255',"内容不能为空|内容最长255字"],
    ];
}