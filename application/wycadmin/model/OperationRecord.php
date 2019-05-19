<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/13
 * Time: 10:56
 */

namespace app\wycadmin\model;


use app\common\model\PublicModel;

class OperationRecord extends PublicModel
{
    protected $updateTime = false;


    public static function recordAdd($adminInfo = null,$suffix = ''){
        return self::infoAdd (
            [
                'aid'=>$adminInfo->id,
                'content'=>'管理员'.$adminInfo->username.$suffix
            ]
        ,['aid','content']);
    }

}