<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/17
 * Time: 14:37
 */
namespace app\wycadmin\validate;

use think\Validate;

class NewsType extends Validate{
    protected $rule = [
        ['title','require|max:32|unique:NewsType',"标题不能为空|标题最长32位|标题已存在"],
    ];
}