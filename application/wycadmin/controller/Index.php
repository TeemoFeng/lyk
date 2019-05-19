<?php
/**
 * Created by PhpStorm.
 * User: aa
 * Date: 2019/1/17
 * Time: 20:07
 */

namespace app\wycadmin\controller;


use app\common\controller\admin\AdminBase;

class Index extends AdminBase
{
    protected $weijihuo = 0;

    protected $jihuo = 1;


    public function index(){
        return $this->fetch();
    }
  
   public function ceshi(){
        $infos =model ('Sell')
            ->select ();
        foreach ($infos as $k=>$v){
            $price = model ('Pipei')
                ->where ('sid',$v->id)
                ->where ('status',$this->normal)
                ->sum ('price');
            if ($v->sy_price == $v->all_price - $price){
                echo '正常'.$v->id.'<br>';
            }else{
                echo '异常'.$v->id.'<br>';
            }
        }
    }
  
   public function ceshi1(){
        $infos =model ('Buy')
            ->select ();
        foreach ($infos as $k=>$v){
            $price = model ('Pipei')
                ->where ('bid',$v->id)
                ->where ('status',$this->normal)
                ->sum ('price');
            if ($v->sy_price == $v->all_price - $price){
                echo '正常'.$v->id.'<br>';
            }else{
                echo '异常'.$v->id.'<br>';
            }
        }
    }
}