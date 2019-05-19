<?php
/**
 * Created by PhpStorm.
 * User: 唐懿德
 * Date: 2019/5/15
 * Time: 21:40
 */

namespace app\h5\controller;


use app\h5\model\Address;
use app\h5\model\CardList;
use app\h5\model\CardOrder;
use app\h5\model\LevelCondition;
use app\h5\model\Member;
use app\h5\model\MemberCard;
use app\h5\model\MemberInfo;
use app\h5\model\MemberLevel;
use think\Db;
use think\Exception;
use think\Request;

class Vipcard extends Base
{
    //卡片列表
    public function cardList(){
        $cards = \app\h5\model\VipCard::getAll('image_path,card_id,strategy,introduce',[
            'status'=>1
        ]);
        $this->assign([
            'cards'=>$cards
        ]);
        return $this->fetch();
    }

    //买卡
    public function cardBuy($id = 0){
        try{
            if (is_numeric($id) && $id > 0){
                $cardInfo = \app\h5\model\VipCard::getInfo([
                    'id'=>$id,
                    'status'=>1
                ],'card_id,title,price');
            }else{
                \exception();
            }
        }catch (Exception $e){
           return $this->redirect('index/index');
        }
        $this->assign([
            'cardInfo'=>$cardInfo
        ]);
        return $this->fetch();
    }

    //购买卡
    public function doCardBuy(){
        try{
            $data = request()->post();
            $this->validateCheck('buyCard',$data);
            $cardInfo = \app\h5\model\VipCard::getInfo([
                'id'=>$data['id'],
                'status'=>1
            ],'card_id,price');
            if (!$cardInfo){
                \exception('卡片种类不存在');
            }
            $data['uid'] = $this->userId;
            $data['buy_num'] = $data['num'];
            $data['card_id'] = $cardInfo->card_id;
            $data['order_number'] = date('Ymd').substr(microtime(true),0,10);
            $data['price'] = $data['buy_num'] * $cardInfo->price;
            #生成订单
            $result = CardOrder::infoAdd($data,['uid','buy_num','card_id','create_time','order_number','price']);
        }catch (Exception $e){
            return $this->error($e->getMessage());
        }
        return $this->success('提交成功','',[
            'res_id'=>$result->id,
            'price'=>$data['price']
        ]);
    }

    //买卡成功后回调
    public function cardBuyReturn($id){
        Db::startTrans ();
        try{
            #获取订单信息判断
            $order = CardOrder::getInfo([
                'id'=>$id,
                'state'=>1
            ],'card_id,buy_num,uid,id,price',true);
            if (!$order){
                \exception('订单不存在或已处理');
            }
            $cardInfo = \app\h5\model\VipCard::getCard ($order->card_id,'*');
            if (!$cardInfo){
                \exception ('卡不存在');
            }
            #获取卡号密码
            $cardList = CardList::getCards ($order->buy_num,$order->card_id);
            #赠送用户卡
            MemberCard::setMemberCard($order->buy_num,$order->uid,$order->card_id,$cardList);
            #修改订单支付状态
            $order::infoEdit($order,['state','payment_time'],[
                'state'=>2,
                'payment_time'=>time()
            ]);

            #发送奖励 升级
            //购买人信息
            $memberInfo = Member::getInfo ([
                'id'=>$order->uid
            ],'parent_idstr,id');
            $idArr = explode (',',substr ($memberInfo->parent_idstr,2,-1));
            $idArr = array_reverse ($idArr);
            $buyMemberLevel = MemberLevel::getInfo ([
                'card_id'=>$order->card_id,
                'uid'=>$order->uid,
            ],'id,state');
            $levelConditions = LevelCondition::where([
                'status'=>1,
                'card_id'=>$order->card_id
            ])->column ('zt_num_condition,team_num_condition,bonus_type,bonus_proportion,level_title','level_number');
            if ($buyMemberLevel && $buyMemberLevel->state == 0){
                $buyMemberLevel::infoEdit ($buyMemberLevel,[
                    'state'
                ],[
                    'state'=>1
                ]);
                MemberLevel::memberUpgrade ($idArr,$order->card_id,$levelConditions);
            }elseif (!$buyMemberLevel){
                MemberLevel::infoAdd ([
                    'uid'=>$order->uid,
                    'card_id'=>$order->card_id,
                    'state'=>1,
                ]);
                MemberLevel::memberUpgrade ($idArr,$order->card_id,$levelConditions);
            }
            if ($cardInfo->open == 1){
                MemberLevel::yjAward($idArr,$order->card_id,$order->price, $levelConditions);
            }
            Db::commit ();
        }catch (Exception $e){
            echo $e->getMessage ();
            Db::rollback ();
            exit;
        }
        echo '回调成功';
    }

      //直接激活用户卡片
    public function activeCard()
    {
        try{
            if(request ()->isAjax()){
                $data = request()->param();
                $info = MemberCard::get(['card_number' => $data['card_number'], 'uid' => $this->userId]);
                if(empty($info)){
                    \exception('未找到该卡片');
                }
                //查询该卡是否已经激活
                if($info->activate == 1){
                    \exception('此卡片已激活');
                }

                if($info->card_id == 1){
                    $map['uid'] = $this->userId;
                    $map['card_id'] = 1;
                    $map['activate'] = 1;
                    $map['end_time'] = ['>', time()];
                    //省内卡 查询用户是否已经有激活的卡片
                    $list = MemberCard::get($map);
                    if($list){
                        \exception('已存在激活生效的卡片，请勿重复激活');
                    }
                }

                //激活此卡片
                $now = date('Y-m-d H:i:s',time());
                $e_time = strtotime("+1years",strtotime($now));
                $data = [
                    'activate' => 1,
                    'create_time' => time(),
                    'end_time'  => $e_time,
                ];
                $res = MemberCard::where(['id' => $info['id']])->update($data);
                if($res === false){
                    \exception('激活失败，请重新操作');
                }

                return ['code' => 1, '激活成功'];

            }
        }catch (Exception $e){
            $msg =  $e->getMessage ();
            return ['code' => 0, 'msg' => $msg];

        }

    }

    public function cardActive()
    {
        $bind = 0;
        $memberXx = MemberInfo::getInfo ([
            'uid'=>$this->userId,
        ]);
        if(!empty($memberXx)){
            $bind = $memberXx->bind;
        }
        if (request ()->isGet ()){
            $cards = \app\h5\model\VipCard::getAll ('title,card_id,card_type',[
                'status'=>1
            ],'price asc');
            $this->assign ([
                'cards'=>$cards,
                'uInfo'=>$this->userInfo,
                'memberXx'=> $memberXx,
                'bind'    => $bind
            ]);
            return $this->fetch();
        }elseif (request ()->isPost()){
            Db::startTrans ();
            try{
                $data = request ()->post ();
                $this->validateCheck ('CardActive2',$data);
                $card = \app\h5\model\VipCard::getCard ($data['card_id'],'card_type,card_id,card_type_number');
                if (!$card){
                    \exception ('卡类不存在');
                }
                $cardInfo = CardList::getInfo ([
                    'card_number'=>$data['card_number'],
                    'buy_type'=>2
                ],'id,card_number,password,card_id,state',true);
              	
                if ($card->card_type == 1){
                    $this->validateCheck ('CardActive1',$data);
                    if ($this->userInfo->parent_id == 0){
                        $this->validateCheck ('CardActive3',$data);
                        $tjInfo =  Member::getInfo ([
                            'mobile'=>$data['pmobile']
                        ],'*',true);
                        if (!$tjInfo){
                            \exception ('推荐人不存在');
                        }
                        if($this->userInfo->mobile == $data['pmobile']){
                			\exception ('推荐人手机号不能填写自己的手机号');
                		}
                        $memberInfo = Member::getInfo ([
                            'id'=>$this->userId
                        ],'*',true);
                        $idStr = $tjInfo->parent_idstr.$tjInfo->parent_idstr.',';
                        $memberInfo::infoEdit ($memberInfo,['parent_id','parent_idstr'],[
                            'parent_id'=>$tjInfo->id,
                            'parent_idstr'=>$idStr
                        ]);
                        $this->addPeopleCount($idStr,$tjInfo->parent_idstr);
                    }
                    $cardInfo = CardList::getInfo ([
                        'card_number'=>$data['card_number'],
                        'buy_type'=>2,
                        'password'=>$data['password']
                    ],'id,card_number,password,card_id,state',true);
                }elseif ($card->card_type == 3){
                    \exception ('卡类不存在');
                }
                if (!$cardInfo){
                    \exception ('卡不存在');
                }elseif ($cardInfo && $cardInfo->state == 0){
                    \exception ('卡已激活过');
                }
                //结束时间
                $now = date('Y-m-d H:i:s',time());
                $e_time = strtotime("+1years",strtotime($now));
                $addData = [
                    'uid'=>$this->userId,
                    'card_type'=>$card->card_type,
                    'card_id'=>$card->card_id,
                    'activate' => 1,
                    'card_number' => $data['card_number'],
                    'password'    => $data['password'],
                    'end_time'    => $e_time,
                ];
                if ($card->card_type == 1){
                    $addData['play_time'] = $card->card_type_number;
                }elseif ($card->card_type == 2){
                    $addData['play_count'] = $card->card_type_number;
                }

                MemberCard::infoAdd ($addData,[
                    'play_count','play_time','card_id','card_type','uid','create_time','end_time','activate','card_number','password'
                ]);
               //更改用户为有效会员
                if($this->userInfo->valid == 0){
                    Member::where(['id' => $this->userId])->update(['valid' => 1]);
                }
                //更改卡片状态
                CardList::where(['card_number' => $data['card_number']])->update(['state' => 0]);
                Db::commit ();
            }catch (Exception $e){
                Db::rollback ();
                return $this->error ($e->getMessage ());
            }
            return $this->success ('卡片已加入卡包','user/usercard',null,2);
        }
        //接收post参数处理
    }

    public function addPeopleCount($idStr,$id){
        Member::where('id','eq',$id)->setInc ('zt_count',1);
        Member::where('id','in',$idStr)->setInc ('team_count',1);
    }


    //卡片互转
    public function cardMakeOut(){
        if (request ()->isGet ()){
            $cards = \app\h5\model\VipCard::getAll ('title,card_id',[
                'status'=>1
            ],'price ASC');
            $this->assign ([
                'cards'=>$cards
            ]);
            return $this->fetch ();
        }elseif (request ()->isPost ()){
            $data = request ()->post ();
            Db::startTrans ();
            try{
                $this->validateCheck ('CardMakeOut',$data);
                $memberCard = MemberCard::getInfo ([
                    'id'=>$data['id'],
                    'uid'=>$this->userId,
                    'activate'=>0,
                    'card_id'=>$data['card_id']
                ],'id,uid',true);
                if (!$memberCard){
                    \exception ('非法操作');
                }
                $putMemberId = Member::getValue ([
                    'mobile'=>$data['put_mobile']
                ],'id');
                if ($putMemberId == $this->userId){
                    \exception ('不能转给自己');
                }
                if (empty($putMemberId)){
                    \exception ('收卡人不存在');
                }
                $memberCard::infoEdit ($memberCard,['uid'],[
                    'uid'=>$putMemberId
                ]);
                Db::commit ();
            }catch (Exception $e){
                Db::rollback ();
                return $this->error ($e->getMessage ());
            }
            return $this->success ('卡片已转出');
        }
    }


    #获取用户所有的卡
    public function getMemberAllCard($cardId){
        if (request ()->isAjax ()){
            try{
                $cardInfo = \app\h5\model\VipCard::getCard ($cardId,'card_type');
                if (!$cardInfo){
                    \exception ('卡片种类不存在');
                }
                $list = MemberCard::getAll('card_number,id',[
                    'uid'=>$this->userId,
                    'card_id'=>$cardId,
                    'activate'=>0,
                    'card_type'=>$cardInfo->card_type
                ],'id ASC');
            }catch (Exception $e){
                return $this->error ($e->getMessage ());
            }
            return $this->success ('获取成功','',$list);
        }
    }
}