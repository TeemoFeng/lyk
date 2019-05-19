<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/16
 * Time: 11:36
 */

namespace app\h5\validate;


use think\Validate;

class UserFeedback extends Validate
{
    protected $rule = [
        [
            'content','require|max:255','反馈内容不能为空|反馈内容最长255字'
        ]
    ];
}