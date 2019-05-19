<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/14
 * Time: 13:47
 */

namespace app\wycadmin\model;


class VipCard extends \app\common\model\VipCard
{
    public $modelName = '旅游卡';


    public function getDeadlineAttr($value,$data){
        switch ($data['card_type']){
            case 1:
                return $data['card_type_number'].'天';
                break;
            case 2:
                return $data['card_type_number'].'次';
                break;
            default:
                return '未知类型';
                break;
        }
    }

    public function getWOpenAttr($value,$data){
        switch ($data['open']){
            case 1:
                return '开';
                break;
            case 0:
                return '关';
                break;
            default:
                return '未知类型';
                break;
        }
    }

    public function getWRecommendAwardTypeAttr($value,$data){
        $arr = [
            '1'=>'线上购买激活奖励',
            '2'=>'线下购买激活奖励',
            '3'=>'都不奖励',
            '4'=>'都奖励'
        ];
        return $arr[$data['recommend_award_type']];
    }
}