<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/14
 * Time: 13:46
 */

namespace app\common\model;


class VipCard extends PublicModel
{
    public static function getCard($cardId,$field = '*'){
        return self::getInfo ([
            'card_id'=>$cardId,
            'status'=>1
        ],$field);
    }
}