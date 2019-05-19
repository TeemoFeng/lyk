<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/14
 * Time: 12:46
 */

namespace app\wycadmin\model;


class Banner extends \app\common\model\Banner
{
    public $modelName= '轮播图';


    public function getTitleAttr($value,$data){
        $title = Scenic::getValue ([
            'id'=>$data['sc_id']
        ],'title');
        if (empty($title)){
            return '未找到';
        }
        return $title;
    }

}