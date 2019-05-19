<?php
/**
 * 行程-控制器
 */

namespace app\h5\controller;


use app\h5\model\Category;
use app\h5\model\Journey;
use app\h5\model\MemberCard;
use app\h5\model\Order;
use app\h5\model\OrderPeopleInfo;
use app\h5\model\Scenic;
use app\h5\model\Special;
use think\Db;
use think\Exception;

class Trip extends Base
{

    /**
     * 景区详情
     * @return mixed
     * @auther enfu
     * @date 2019/5/13 16:46
     */
    public function detail($jid = 0)
    {
        try{
            if (is_numeric ($jid)){
                $journey = Journey::getInfo ([
                    'id'=>['eq',$jid],
                    'status'=>['eq',1]
                ],'id,v_id,mobile,this_people_count,max_people_count,s_time,e_time,sc_id');
                if (empty($journey)){
                    \exception ('');
                }
                $info = $journey->getScenic('id,circuit,title,star,addr,introduce,notice')->where('status','eq',1)->find();
                if (empty($info)){
                    \exception ('');
                }
                $banner = $info->ScenicImage()->select();
                $info->circuit = htmlspecialchars_decode($info->circuit);
                $info->introduce = htmlspecialchars_decode($info->introduce);
                $info->notice = htmlspecialchars_decode($info->notice);
            }else{
                \exception ('');
            }
        }catch (Exception $e){
            return $this->redirect ('h5/Index/index');
        }
        $this->assign ([
            'info'=>$info,
            'banner'=>$banner,
            'journey'=>$journey
        ]);
        return $this->fetch();
    }


    /**
     * 推荐详情
     * @return mixed
     * @auther enfu
     * @date 2019/5/13 16:46
     */
    public function tjdetail($sid = 0)
    {
        try{
            if (is_numeric ($sid)){
                $journey = Special::getInfo ([
                    'id'=>['eq',$sid],
                    'status'=>['eq',1]
                ],'id,v_id,mobile,max_people_count,s_time,e_time,sc_id');
                if (empty($journey)){
                    \exception ('');
                }
                $info = $journey->getScenic('id,circuit,title,star,addr,introduce,notice')->where('status','eq',1)->find();
                if (empty($info)){
                    \exception ('');
                }
                $banner = $info->ScenicImage()->select();
                $info->circuit = htmlspecialchars_decode($info->circuit);
                $info->introduce = htmlspecialchars_decode($info->introduce);
                $info->notice = htmlspecialchars_decode($info->notice);
            }else{
                \exception ('');
            }
        }catch (Exception $e){
            echo $e->getMessage ();
            exit;
            //return $this->redirect ('h5/Index/index');
        }
        $this->assign ([
            'info'=>$info,
            'banner'=>$banner,
            'journey'=>$journey
        ]);
        return $this->fetch();
    }


    public function getJourStatus($jid,$peopleCount = 1,$field='*'){
        if (!is_numeric ($jid)){
            \exception ('非法参数');
        }
        #获取行程信息
        $jouInfo = Journey::getInfo ([
            'id'=>$jid,
            'status'=>1
        ],$field);
        if (!$jouInfo || strtotime ($jouInfo->e_time) < time ()){
            \exception ('预约已结束');
        }
        $scInfo = $jouInfo->getScenic('title')->where('status','eq',1)->find();
        if (!$scInfo){
            \exception ('景区已下架');
        }
        $jouInfo->title = $scInfo->title;
        if ($jouInfo->site != '' && $jouInfo->vehicle == 1){
            $jouInfo->site = explode (',',$jouInfo->site);
        }
        #判断是否能继续预约
        if ($jouInfo->max_people_count < $jouInfo->this_people_count+$peopleCount){
            \exception ('预约位置已满');
        }
        return $jouInfo;
    }

    /**
     * 景区详情
     * @return mixed
     * @auther enfu
     * @date 2019/5/13 16:46
     */
    public function tripOrder($jid = 0)
    {
        try{
            $jouInfo = $this->getJourStatus($jid);
            MemberCard::memberCardCheck($jouInfo->card_id,$this->userId);
        }catch (Exception $e){
            if (request ()->isAjax ()){
                return $this->error ($e->getMessage ());
            }
            return $this->redirect ('index/index');
        }
        if (request ()->isAjax ()){
            return $this->success ('预约中..',"trip/tripOrder?jid=".$jid,null,0);
        }
        $this->assign ([
            'jouInfo'=>$jouInfo
        ]);
        return $this->fetch();
    }

    #遍历出行人信息
    private function getPeopleInfos($data,$returnArr = []){
        if (!isset($data['name'])){
            \exception ('请添加出行人');
        }
        foreach ($data['name'] as $key=>$value){
            $returnArr[$key]['name'] = $value;
            $returnArr[$key]['name_id'] = $data['name_id'][$key];
        }
        return $returnArr;
    }


    #提交预约
    public function reserveSubmit(){
        if (request ()->isPost ()){
            $data = request ()->post ();
            Db::startTrans ();
            try{
                $peopleArr = $this->getPeopleInfos ($data);
                $touristInfo = [];
                foreach ($peopleArr as $key=>$value){
                    if (empty($value['name']) || empty($value['name_id'])){
                        \exception('请完善第'.($key+1) .'位出行人的信息');
                    }else{
                        $touristInfo[$key]['name'] = $value['name'];
                        $touristInfo[$key]['name_id'] = $value['name_id'];
                        $this->validateCheck ('PeopleCheck',$touristInfo[$key]);
                    }
                }
                $jouInfo = $this->getJourStatus($data['j_id']);
                $data['people_count'] = count ($touristInfo);
                if ($jouInfo->site != '' && $jouInfo->vehicle == 1 && !isset($jouInfo->site[$data['site']-1])){
                    \exception ('乘车点不存在');
                }else if ($jouInfo->site != '' && $jouInfo->vehicle == 1){
                    $data['site'] = $jouInfo->site[$data['site']-1];
                }
                $data['uid'] = $this->userId;
                $data['cash'] = $data['people_count'] * $jouInfo->cash;
                $data['order_number'] = date ('Ymd').substr (microtime (true),0,10);
                $data['card_id'] = $jouInfo->card_id;
                $result = Order::infoAdd ($data,['order_number','card_id','site','create_time','people_count','j_id','cash','uid']);
                foreach ($touristInfo as $k=>$v){
                    $touristInfo[$k]['oid'] = $result->id;
                    $touristInfo[$k]['j_id'] = $data['j_id'];
                }
                $OrderPeopleInfo = new OrderPeopleInfo();
                $OrderPeopleInfo->allowField (['oid','j_id','name','name_id'])->isUpdate (false)->saveAll($touristInfo);
                Db::commit ();
            }catch (Exception $e){
                Db::rollback ();
                return $this->error ($e->getMessage ());
            }
            return $this->success('订单已生成','',[
                'order_id'=>$result->id,
                'cash'=>$data['cash'],
            ]);
        }
    }

    //预约押金支付成功后回调接口
    public function journeyOrderCallBack($id){
        Db::startTrans ();
        try{
            #获取订单信息
            $order = Order::getInfo ([
                'id'=>$id,
                'state'=>1,
                'status'=>1
            ],'*',true);
            if (!$order){
                \exception ('订单不存在');
            }
            $jouInfo = Journey::getInfo ([
                'id'=>['eq',$order->j_id],
                'status'=>1
            ]);
            if (!$jouInfo){
                \exception ('行程不存在');
            }
            #获取卡种类信息
            $cardInfo = \app\h5\model\VipCard::getCard ($order->card_id,'*');
            switch ($cardInfo->card_type){
                case 1:
                    #按日期结束的卡
                    #真实花费卡次数为1
                    $state = 3;
                    $sj_card_num = MemberCard::UsecardType1 ($order->uid,$order->card_id);
                    break;
                case 2:
                    #按使用次数
                    $state = 2;
                    $sj_card_num = MemberCard::UsecardType2 ($order->uid,$order->card_id,$order->xz_card_num);
                    break;
                default:
                    \exception ('卡片类型不存在');
                    break;
            }
            #修改订单信息
            $order::infoEdit ($order,'state,sj_card_num,fukuan_time',[
                'state'=>$state,
                'sj_card_num'=>$sj_card_num,
                'fukuan_time'=>time ()
            ]);
            if ($jouInfo->this_people_count + $order->people_count >= $jouInfo->max_people_count){
                $state = 0;
            }
            $jouInfo::infoEdit ($jouInfo,'state,this_people_count',[
                'this_people_count'=>$jouInfo->this_people_count + $order->people_count,
                'state'=>$state
            ]);
            Db::commit ();
        }catch (Exception $e){
            Db::rollback ();
            echo $e->getMessage ();
            exit;
        }
        echo '预约成功';
    }


}