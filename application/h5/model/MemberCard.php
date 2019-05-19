<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/15
 * Time: 17:57
 */

namespace app\h5\model;


use app\common\model\Card;
use think\Db;

class MemberCard extends \app\common\model\MemberCard
{

    public static function memberCardCheck($cardId = 0,$uid = 0){
        $cardInfo = VipCard::getCard ($cardId,'card_type,title');
        if (!$cardInfo){
            exception ('预定需要激活的卡类不存在');
        }
        switch ($cardInfo->card_type){
            #按日期结束
            case 1:
                self::check1($cardId,$uid,$cardInfo->title);
                break;
            #按使用次数
            case 2:
                self::check2($cardId,$uid,$cardInfo->title);
                break;
            default:
                exception ('未知错误');
                break;
        }
    }

    private static function check1($cardId,$uid,$title){
        $info = self::getInfo ([
            'card_type'=>1,
            'uid'=>['eq',$uid],
            'activate'=>1,
            'state'=>['eq',1],
            'end_time'=>['>',time ()],
            'card_id'=>$cardId
        ],'id');
        if (!$info){
            exception ('请先激活'.$title.'后在预约');
        }
    }

    private static function check2($cardId,$uid,$title){
        $info = self::getInfo ([
            'card_type'=>2,
            'uid'=>['eq',$uid],
            'activate'=>1,
            'state'=>['eq',1],
            'play_count'=>['>',0],
            'card_id'=>$cardId
        ]);
        if (!$info){
            exception ('请到先激活'.$title.'后在预约');
        }
    }

    /**
     * 获取这个用户的次数卡还能用多少次
     */
    private function getCardUseNum($uid = 0,$card_id = 0){
        $cardNum = self::getCount ([
            'uid'=>$uid,
            'card_id'=>['eq',$card_id],
            'state'=>['eq',1],
            'end_time'=>['>',time ()]
        ],'id');
    }



    #卡类型为1业务处理
    public static function UsecardType1($uid = 0,$cardId = 0){
        #查看是否有类型为1的卡
        $cardInfo = self::getMemberCard ($uid,$cardId,1,'id');
        if (!$cardInfo){
            exception ('不存在类型为1的卡或已过期');
        }
        return 1;
    }
    #获取用户的旅游卡
    public static function getMemberCard($uid = 0,$cardId = 0,$cardType = 1,$field = '*',$lock = false){
        return self::getInfo ([
            'uid'=>['eq',$uid],
            'card_id'=>['eq',$cardId],
            'card_type'=>['eq',$cardType],
            'state'=>['eq',1],
            'end_time'=>['>',time ()]
        ],$field,$lock);
    }

    #卡类型为2业务处理
    public static function UsecardType2($uid = 0,$cardId = 0,$writeNum = 0){
        #查看是否有类型为2的卡
        $returnCount = 0;
        $cardInfos = self::getMemberCards($uid,$cardId,2);
        if(empty($cardInfos)){
            exception ('不存在可用类型为2的卡');
        };
        foreach ($cardInfos as $key=>$card){
                if ($card->play_count == $writeNum){
                    $writeNum = 0;
                    $returnCount += $card->play_count;
                    $card::infoEdit ($card,'play_count,state',[
                        'play_count'=>0,
                        'state'=>0
                    ]);
                    break;
                }elseif ($card->play_count >= $writeNum){
                    $writeNum = 0;
                    $returnCount += $writeNum;
                    $card::infoEdit ($card,'play_count,state',[
                        'play_count'=>$card->play_count - $writeNum,
                    ]);
                    break;
                }elseif ($card->play_count <= $writeNum){
                    $writeNum = $writeNum - $card->play_count;
                    $returnCount += $card->play_count;
                    $card::infoEdit ($card,'play_count,state',[
                        'play_count'=>0,
                        'state'=>0
                    ]);
                }
        }
        return $returnCount;
    }

    public static function getMemberCards($uid = 0,$cardId = 0,$cardType = 2,$field = '*',$lock = false){
        return self::getAll($field,[
            'uid'=>['eq',$uid],
            'card_id'=>['eq',$cardId],
            'card_type'=>['eq',$cardType],
            'state'=>['eq',1],
            'play_count'=>['>',0]
        ],'id ASC',$lock);
    }


    public static function setMemberCard($num = 0,$uid = 0,$cardId,$cardList = null){
        $cardInfo = VipCard::getCard ($cardId,'card_type,card_type_number');
        $data['card_id'] = $cardId;
        $data['card_type'] = $cardId;
        $data['uid'] = $uid;
        if ($cardInfo->card_type == 1){
            $data['play_time'] = $cardInfo->card_type_number;
        }elseif ($cardInfo->card_type == 2){
            $data['play_count'] =$cardInfo->card_type_number;
        }
        $oData = [];
        for ($i=0;$i<$num;$i++){
            $oData[$i] = $data;
            $oData[$i]['card_number'] = $cardList[$i]->card_number;
            $oData[$i]['password'] = $cardList[$i]->password;
            $cardList[$i]::infoEdit($cardList[$i],['state'],[
                'state'=>0
            ]);
        }
        (new self())->allowField (['create_time','play_count','play_time','uid','card_type','card_id','password','card_number'])->isUpdate(false)->saveAll ($oData);
    }


}