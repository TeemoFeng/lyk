<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/14
 * Time: 18:04
 */

namespace app\wycadmin\validate;


use think\Validate;

class Journey extends Validate
{
    protected $rule = [
        ['sc_id', 'require|between:1,9999999|integer', '景区id不能为空|景区id只能填写1-9999999|景区id只能填写数字'],
        ['tickets_price', 'require|gt:0|number', '门票价格不能为空|门票价格必须大于0|门票价格必须为数字'],
        ['cid', 'require|gt:0|integer', '请选择预约分类|预约分类id必须大于0|预约分类id只能为整数'],
        ['card_id', 'require|gt:0|integer', '请选择可预出行的旅游卡|旅游卡id必须大于0|旅游卡id只能为整数'],
        ['v_id', 'require|gt:0|integer', '请选择出行工具|出行工具id必须大于0|出行工具id只能为整数'],
        ['max_people_count', 'require|between:1,9999|integer', '可预约人数不能为空|可预约人数只能填写1-9999|可预约人数只能填写数字'],
        ['mobile', 'require|max:32', '咨询电话不能为空|咨询电话不能大于32字'],
        //['vehicle', 'require|in:0,1|integer', '请选择是否为直通车|是否直通车选项只能选择0or1|选择是否为直通车只能为整数'],
        //['vehicle_type', 'require|in:1,2|integer', '请选择直通车类型|直通车类型选择错误|直通车类型选择错误'],
        //['site', 'max:128', '上车地点最长128字'],
        ['s_time', 'require|date', '开始时间不能为空|开始时间格式错误'],
        ['e_time', 'require|date', '结束时间不能为空|结束时间格式错误'],
    ];
}