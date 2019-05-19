<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/14
 * Time: 16:05
 */

namespace app\h5\model;


class Scenic extends \app\common\model\Scenic
{

    public function ScenicImage(){
        return $this->hasMany ('ScenicImage','gl_id','id')->field ('image');
    }
}