<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/16
 * Time: 15:16
 */

namespace app\h5\model;


class ScenicImage extends \app\wycadmin\model\ScenicImage
{
    public function getImageAttr($value){
        return request ()->domain ().$value;
    }
}