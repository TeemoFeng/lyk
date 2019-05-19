<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/17
 * Time: 9:07
 */

namespace app\common\model;


use app\h5\model\Vehicle;

class Special extends PublicModel
{
    public function getScenic($field = '*'){
        return $this->hasOne ('scenic','id','sc_id')->field ($field);
    }

    public function getSTimeAttr($value){
        return date ('Y-m-d',$value);
    }

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

    public function getETimeAttr($value){
        return date ('Y-m-d',$value);
    }
}