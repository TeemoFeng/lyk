<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/13
 * Time: 13:25
 */

namespace app\wycadmin\model;


class Region extends \app\common\model\Region
{
    public $modelName= '地区';

    public function getParentTitleAttr($value,$data){
        $title =  self::getValue ([
            'id'=>$data['pid']
        ],'title');
        if (empty($title)){
            return '顶级分类';
        }
        return $title;
    }


    public function getAllParentAttr($value,$data){
        $result = $this->getAllParent ($data['pid'],[$data['title']]);
        array_push ($result,'地球');
        $result = array_reverse ($result);
        return implode ('>',$result);
    }


    //获取所有分类上级
    public function getAllParent($cid=0,$returnArr = []){
        $category = self::field ('title,pid')->where ('id',$cid)->find ();
        if ($category){
            $returnArr[] = $category->title;
            $returnArr = $this->getAllParent($category->pid,$returnArr);
        }
        return $returnArr;
    }
}