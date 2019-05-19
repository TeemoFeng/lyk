<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/5
 * Time: 21:05
 */

namespace app\common\model;


class Category extends PublicModel
{

    /**
     * 获取cid 下所有分类
     * @param $cid
     * @param array $typeArr
     * @return array
     */
    public static function getAllSon($cid,$typeArr=[]){
        $arr = model('category')
            ->field('id')
            ->where('cid',$cid)->where('status',1)
            ->select();
        static $n = 0;
        foreach($arr as $k=>$v){
            $v->level = $n;
            $typeArr[$v->id] = $v->id;
            $n++;
            $typeArr =self::getAllSon($v->id,$typeArr);
            $n--;
        }
        return $typeArr;
    }



    public function Category(){
        return $this->hasMany('Category','cid','id')->field ('title,id,cid')->where ('status','eq',1);
//        return Card::all (function ($query) use ($id){
//            $query->field('title')->where('cid',$id)->where('status',1);
//        });

    }


}