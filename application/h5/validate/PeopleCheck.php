<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/15
 * Time: 17:38
 */

namespace app\h5\validate;


use think\Validate;

class PeopleCheck extends Validate
{
    protected $rule = [
        ['name_id','require|max:24','身份证号不能为空|身份证号最长24位'],
        ['name','require|max:8','姓名不能为空|姓名最长8位'],
    ];
}