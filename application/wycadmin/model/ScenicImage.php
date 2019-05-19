<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/14
 * Time: 10:50
 */

namespace app\wycadmin\model;


use app\common\model\PublicModel;

class ScenicImage extends PublicModel
{
    protected $autoWriteTimestamp = false;


    public static function imageDel($pid = 0){
        $images = self::getAll('image,id',[
            'gl_id'=>$pid
        ]);
       if ($images){
            foreach ($images as $k=>$v){
                @unlink (ROOT_PATH.'public'.$v->image);
                $v->delete ();
            }
        }
    }
}