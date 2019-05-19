<?php
/**
 * Created by PhpStorm.
 * User: 唐懿德
 * Date: 2019/5/15
 * Time: 21:40
 */

namespace app\h5\model;


class VipCard extends \app\common\model\VipCard
{
    public function recommendAward($parentId = 0, $cardInfo = null, $buyType = '')
    {
        switch ($cardInfo->recommend_award_type) {
            case 1:
                if ($buyType == 'up') {
                    self::giveAward ($parentId,$cardInfo->recommend_award_price_up);
                }
                return;
                break;
            case 2:
                if ($buyType == 'down') {
                    self::giveAward ($parentId,$cardInfo->recommend_award_price_down);
                }
                break;
            case 4:
                if ($buyType == 'down') {
                    self::giveAward ($parentId,$cardInfo->recommend_award_price_down);
                }elseif ($buyType == 'up'){
                    elf::giveAward ($parentId,$cardInfo->recommend_award_price_up);
                }
                break;
            default:
                return;
        }
        return;
    }

    private static function giveAward($parentId,$Award,$cardId)
    {
       $member = Member::getInfo ([
           'id'=>$parentId,
       ],'*',true);
       if (!$member){
           return;
       }
       $level = MemberLevel::getInfo ([
           'uid'=>$parentId,
           'state'=>1,
           'card_id'=>$cardId
       ]);
       if (!$level){
           return;
       }
       $member::infoEdit ($member,[
           'integral'
       ],[
           'integral'=>$member+$Award
       ]);
       Finance::financeRecord ($member,1,$Award,'直推人激活卡');
    }
}