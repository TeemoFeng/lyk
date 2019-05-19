<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/13
 * Time: 10:00
 */

namespace app\wycadmin\model;


class Category extends \app\common\model\Category
{
    public $modelName= '分类';

    public function getParentTitleAttr($value,$data){
        $title =  self::getValue ([
            'id'=>$data['cid']
        ],'title');
        if (empty($title)){
            return '顶级分类';
        }
        return $this;
    }

    public function getWDisplayAttr($value,$data){
        switch ($data['display_type']){
            case 1:
                return '分月显示';
                break;
            case 2:
                return '全部显示';
                break;
            default:
                return '暂无类型';
                break;
        }
    }


    public function getAllParentAttr($value,$data){
        return substr ($this->getAllParent ($data['cid']),0,-1);
    }


    //获取所有分类上级
    public function getAllParent($cid=0,$returnStr = '顶级分类>'){
        $category = model ('Category')->field ('id,title,cid')->where ('id',$cid)->find ();
        if ($category){
            $returnStr .= $category->title.'>';
            $returnStr = $this->getAllParent($category->cid,$returnStr);
        }
        return $returnStr;
    }


}