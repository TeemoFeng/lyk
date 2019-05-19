<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/6
 * Time: 9:51
 */

namespace app\common\model;


class Rule extends PublicModel
{
    /**
     * 根据传入字段名返回值
     * @param $field 传入字段名
     * @return mixed
     */
    public static function getFieldValue($field){
        return Rule::where('id',1)->value ($field);
    }
}