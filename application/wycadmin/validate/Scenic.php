<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/14
 * Time: 10:55
 */

namespace app\wycadmin\validate;


use think\Validate;

class Scenic extends Validate
{
    protected $rule = [
        ['category_id', 'require', '景点类型不能为空'],
        ['title', 'require|max:64', '景区标题不能为空|景区标题不能大于64字'],
        ['intro', 'require|max:64', '景区简介不能为空|景区简介不能大于64字'],
        ['addr', 'require|max:64', '景区所在地不能为空|景区所在地不能大于64字'],
        ['star', 'require|between:0,5|integer', '星级不能为空|星级只能填写1-5|星级只能填写整数'],
        //['introduce', 'require', '景区介绍不能为空'],
        //['circuit', 'require|max:255', '自驾游线路不能为空|自驾游线路最长255字'],
        //['notice', 'require|date', '须知不能为空|须知最长255字'],
    ];
}