<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/15
 * Time: 9:57
 */

namespace app\h5\model;


class Journey extends \app\common\model\Journey
{
    public function getWVidAttr($value,$data){
        $vid = Vehicle::getValue ([
            'id'=>$data['v_id'],
            'status'=>1
        ],'title');
        if (empty($vid)){
            return '暂无出行方式';
        }
        return $vid;
    }
}