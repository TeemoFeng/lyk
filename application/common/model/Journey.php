<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/14
 * Time: 17:03
 */

namespace app\common\model;


class Journey extends PublicModel
{
    public function getScenic($field = '*'){
        return $this->hasOne ('scenic','id','sc_id')->field ($field);
    }
    public function getETimeAttr($value){
        return date('Y-m-d',$value);
    }

    public function getSTimeAttr($value){
        return date('Y-m-d',$value);
    }

}