<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/14
 * Time: 9:25
 */

namespace app\wycadmin\model;


class Scenic extends \app\common\model\Scenic
{
    public $modelName= '景区';

    public function setSTimeAttr($value){
        return strtotime ($value);
    }

    public function setETimeAttr($value){
        return strtotime ($value);
    }

    public function getSTimeAttr($value){
        return date ('Y-m-d',$value);
    }

    public function getETimeAttr($value){
        return date ('Y-m-d',$value);
    }
}