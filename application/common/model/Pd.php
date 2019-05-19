<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/29
 * Time: 17:05
 */

namespace app\common\model;


class Pd extends PublicModel
{
    public function getImageAttr($value)
    {
        return '../../uploads/'.$value;
    }

    protected function getTypeAttr($value){
        $status = ['pc'=>'PC端轮播图','yd'=>'移动端轮播图','pc_zq'=>'PC端专区','pc_pd'=>'PC端频道'];
        return $status[$value];
    }
}