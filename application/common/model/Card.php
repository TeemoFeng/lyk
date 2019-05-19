<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/6
 * Time: 11:42
 */

namespace app\common\model;


use think\Model;

class Card extends Model
{
    public function getSizePriceAttr($value,$data){
       $price = ProductSize::get ([
           'size'=>$data['size'],
           'pid'=>$data['pid'],
           'status'=>1
       ]);
       if (!$price){
           return 999999;
       }else{
           return $price->price;
       }
    }

}