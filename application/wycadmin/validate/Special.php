<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/14
 * Time: 18:04
 */

namespace app\wycadmin\validate;


use think\Validate;

class Special extends Validate
{
    protected $rule = [
        ['sc_id', 'require|between:1,9999999|integer', '景区id不能为空|景区id只能填写1-9999999|景区id只能填写数字'],
        ['heat', 'require|between:1,5|integer', '热度不能为空|热度只能填写1-5|热度只能填写整数'],
        ['v_id', 'require|gt:0|integer', '请选择出行工具|出行工具id必须大于0|出行工具id只能为整数'],
        ['arrange', 'require|max:128', '安排不能为空|安排最长128字'],
        ['max_people_count', 'require|between:1,9999|integer', '可预约人数不能为空|可预约人数只能填写1-9999|可预约人数只能填写数字'],
        ['mobile', 'require|max:32', '咨询电话不能为空|咨询电话不能大于32字'],
        ['s_time', 'require|date', '开始时间不能为空|开始时间格式错误'],
        ['e_time', 'require|date', '结束时间不能为空|结束时间格式错误'],
    ];
}