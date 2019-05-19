<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/17
 * Time: 11:42
 */

namespace app\h5\model;


class MemberLevel extends \app\common\model\MemberLevel
{
    #用户升级
    public static function memberUpgrade($idArr = [],$cardId = 0,$levelConditions){
        foreach ($idArr as $k=>$v){
            $buyMemberLevel = MemberLevel::getInfo ([
                'card_id'=>$cardId,
                'uid'=>$v,
            ],'id,state,team_count,zt_count,level_number,uid',true);
            $data = [];
            if ($buyMemberLevel){
                $data = [
                    'team_count'=>$buyMemberLevel->team_count+1
                ];
                if ($k == 0){
                    $data['zt_count'] = $buyMemberLevel->zt_count + 1;
                }
                $result = $buyMemberLevel::infoEdit ($buyMemberLevel,[
                    'zt_count',
                    'team_count'
                ],$data);
                $result = $buyMemberLevel;
            }elseif (!$buyMemberLevel){
                $data = [
                    'uid'=>$v,
                    'card_id'=>$cardId,
                    'team_count'=>1,
                    'level_number'=>0,
                    'zt_count'=>0,
                ];
                if ($k == 0){
                $data['zt_count'] = 1;
                }
                $result = MemberLevel::infoAdd ($data,['uid','card_id','team_count','zt_count','level_number']);
            }
            self::Upgrade($result,$levelConditions);
        }
    }


    public static function yjAward($parentArr = [],$cardId = 0,$price = 0,$levelConditions = []){
        foreach ($parentArr as $k=>$v){
            $levelInfo = $buyMemberLevel = MemberLevel::getInfo ([
                'card_id'=>$cardId,
                'uid'=>$v,
                'state'=>1
            ],'id,level_number,uid');
            if (!$levelInfo){
                continue;
            }
            if (isset($levelConditions[$levelInfo->level_number]) && $levelConditions[$levelInfo->level_number]['bonus_type'] == 1){
                $member = Member::getInfo ([
                    'id'=>$levelInfo->uid
                ],'id,integral',true);
                if ($member){
                    $jiangli = $price * $levelConditions[$levelInfo->level_number]['bonus_proportion'] *0.01;
                    $member::infoEdit ($member,['integral'],[
                        'integral'=>$member->integral + $jiangli
                    ]);
                    Finance::financeRecord ($member,1,$jiangli,$levelConditions[$levelInfo->level_number]['level_title'].'奖励');
                    break;
                }
            }
        }
        return;
    }


    private static function Upgrade($levelInfo,$levelConditions){
        if (empty($levelConditions)){
            return;
        }
        if (isset($levelConditions[$levelInfo->level_number+1]) && $levelInfo->zt_count >= $levelConditions[$levelInfo->level_number+1]['zt_num_condition'] && $levelInfo->team_count >= $levelConditions[$levelInfo->level_number+1]['team_num_condition']){
            $levelInfo::infoEdit ($levelInfo,['level_number'],[
                'level_number'=>$levelConditions[$levelInfo->level_number+1]['level_number']
            ]);
        }
    }
}