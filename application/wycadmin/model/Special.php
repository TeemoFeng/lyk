<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/17
 * Time: 9:07
 */

namespace app\wycadmin\model;


class Special extends \app\common\model\Special
{
    public $modelName = '每周特价';

    public function setSTimeAttr($value){
        return strtotime ($value);
    }

    public function setETimeAttr($value){
        return strtotime ($value);
    }
}