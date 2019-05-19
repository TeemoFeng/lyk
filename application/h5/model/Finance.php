<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/17
 * Time: 11:34
 */

namespace app\h5\model;


class Finance extends \app\common\model\Finance
{
    #记录奖金
    /**
     * @param null $userInfo 用户信息
     * @param int $type 加或减 0减1加
     * @param int $price 本次消费金额
     * @return \app\common\model\BaseModel|void
     */
    public static function financeRecord($userInfo = null,$type = 0,$price = 0,$content){
        if ($price == 0){
            return;
        }
        return self::infoAdd ([
            'uid'=>$userInfo->id,
            'balance'=>$userInfo->integral,
            'price'=>$price,
            'plusormin'=>$type,
            'content'=>$content
        ],['uid','balance','create_time','price','plusormin','content']);
    }

}