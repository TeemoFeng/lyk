<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/28
 * Time: 11:03
 */

namespace app\common\model;


class OrderPeopleInfo extends PublicModel
{
    public function Product()
    {
        return $this->hasOne('Product','id','pid')->field('title,yd_image,pc_image');
    }
}