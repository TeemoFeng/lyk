<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/6
 * Time: 14:01
 */

namespace app\common\model;


class Order extends PublicModel
{
//    protected $insert = ['order_number'];
////
////
////    protected function setOrderNumberAttr(){
////        return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
////    }


    public function getWStateAttr($value,$data)
    {
        $status = [1=>'待付款',2=>'待审核',3=>'已预约',4=>'已出行'];
        return $status[$data['state']];
    }


    public function getPaymentTimeAttr($value){
        return date ('Y-m-d H:i:s',$value);
}

    public function OrderProduct(){
        return $this->hasMany ('OrderProduct','oid')->field ('unit_price,all_price,size,colour,count,pid,id as iid');
    }

    public function journeyInfo($field = '*'){
        return $this->hasOne ('Journey','id','j_id')->field ($field);
    }

}