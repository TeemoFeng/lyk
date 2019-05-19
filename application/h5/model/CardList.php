<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/16
 * Time: 17:55
 */

namespace app\h5\model;


use app\common\model\PublicModel;

class CardList extends PublicModel
{
    public static function getCards($num,$cardId){
        return self::all (function ($query) use($num,$cardId){
            $query->lock(true)->where([
                'card_id'=>$cardId,
                'state'=>1,
                'status'=>1
            ])->field('password,card_number,id')->limit(0,$num);
        });
    }
}