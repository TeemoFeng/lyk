<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/14
 * Time: 9:24
 */

namespace app\wycadmin\controller;

use app\common\controller\admin\AdminBase;
use app\wycadmin\model\Journey as JourneyModel;
use app\wycadmin\model\OperationRecord;
use app\wycadmin\model\Scenic as ScenicModel;
use think\Db;
use think\Exception;
use think\Request;

class Journey extends AdminBase
{
    /**
     * 行程列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function journeyList($pid = 0)
    {
        $list = JourneyModel::getInfoPage ([
            'status' => ['neq', $this->delete],
        ], '*', 'id DESC', $this->listRows);
        $this->assign (
            [
                'pid' => $pid,
                'List' => $list,
            ]
        );
        return $this->fetch ();
    }

    public function journeyList2($id = 0)
    {
        $list = JourneyModel::getInfoPage ([
            'status' => ['neq', $this->delete],'sc_id' => $id
        ], '*', 'id DESC', $this->listRows);
        $this->assign (
            [
                'List' => $list,
            ]
        );
        return $this->fetch ('journey_list');
    }


    //添加行程
    public function journeyAdd($id = 0, $category_id = 0)
    {
        if (request ()->isGet ()) {

            $Card = \app\wycadmin\model\VipCard::all (function ($query){
                $query->field('title,card_id')->where('status','eq',1);
            });
            $Vehicle = \app\wycadmin\model\Vehicle::all (function ($query){
                $query->field('title,id')->where('status','eq',1);
            });
            $List = $this->getSonList(0,'Category','cid');
            $this->assign ([
                'List'=>$List,
                'Card'=>$Card,
                'Vehicle'=>$Vehicle
                ]);
            //获取景点名称
            $scenic_name = ScenicModel::where(['id' => $id])->value('title');
            $this->assign(['scenic_id' => $id]); //景点id
            $this->assign(['scenic_name' => $scenic_name]); //景点名
            $this->assign(['category_id' => $category_id]); //景点分类
            return $this->fetch ();
        } else if (request ()->isPost ()) {
            $data = input ('post.');
            if($data['cid'] > 2){
                //1 国外 2省外 3省内
                $data['card_id'] = 2;
            }else{
                $data['card_id'] = 1;
            }
            $this->validateCheck ('Journey', $data);
            Db::startTrans ();
            try {
                $timeArr = explode ('-',$data['s_time']);
                $data['year'] = $timeArr[0];
                $data['week'] = $this->current_week ($data['s_time']);
                $data['month'] = $timeArr[1];
                $sc = ScenicModel::getInfo ([
                    'id' => $data['sc_id']
                ], 'id,title');
                if (!$sc) {
                    \exception ('输入的景区编号不存在');
                }
                JourneyModel::infoAdd ($data,[
                    'sc_id', 's_time','e_time', 'create_time', 'update_time','week','year','month','vehicle_type','vehicle','mobile','max_people_count','cid','card_id','v_id','tickets_price','cash'
                ]);
                OperationRecord::recordAdd ($this->adminInfo, '新增了景区' . $sc->title . '的行程');
                Db::commit ();
            } catch (Exception $e) {
                Db::rollback ();
                return $this->error ($e->getMessage ());
            }
            return $this->success ('行程添加成功', "scenic/sceniclist", null, 2);
        }
    }

    public function journeyAdd2($id, $category_id){
        if (request ()->isGet ()) {

            $Card = \app\wycadmin\model\VipCard::all (function ($query){
                $query->field('title,card_id')->where('status','eq',1);
            });
            $Vehicle = \app\wycadmin\model\Vehicle::all (function ($query){
                $query->field('title,id')->where('status','eq',1);
            });
            $List = $this->getSonList(0,'Category','cid');
            $this->assign ([
                'List'=>$List,
                'Card'=>$Card,
                'Vehicle'=>$Vehicle
            ]);
            $this->assign(['scenic_id' => $id]);
            $this->assign(['category_id' => $category_id]);
            return $this->fetch ();
        } else if (request ()->isPost ()) {
            $data = input ('post.');
            if($data['cid'] > 2){
                //1 国外 2省外 3省内
                $data['card_id'] = 2;
            }else{
                $data['card_id'] = 1;
            }
            $this->validateCheck ('Journey', $data);
            Db::startTrans ();
            try {
                $timeArr = explode ('-',$data['s_time']);
                $data['year'] = $timeArr[0];
                $data['week'] = $this->current_week ($data['s_time']);
                $data['month'] = $timeArr[1];
                $sc = ScenicModel::getInfo ([
                    'id' => $data['sc_id']
                ], 'id,title');
                if (!$sc) {
                    \exception ('输入的景区编号不存在');
                }
                JourneyModel::infoAdd ($data,[
                    'sc_id', 's_time','e_time', 'create_time', 'update_time','week','year','month','vehicle_type','vehicle','mobile','max_people_count','cid','card_id','v_id','tickets_price','cash'
                ]);
                OperationRecord::recordAdd ($this->adminInfo, '新增了景区' . $sc->title . '的行程');
                Db::commit ();
            } catch (Exception $e) {
                Db::rollback ();
                return $this->error ($e->getMessage ());
            }
            return $this->success ('行程添加成功', "journey/journeylist", null, 2);
        }
    }


    public function current_week ($date_of_firstday='2006-8-28'){
        $date_now=date('j',strtotime ($date_of_firstday)); //得到今天是几号
        $cal_result=ceil($date_now/7); //计算是第几个星期几
        return $cal_result;
    }


    public function getRegionSon($pid = 0)
    {
        $region = \app\wycadmin\model\Region::getAll ('title,id', [
            'status' => 1,
            'pid' => $pid
        ]);
        return $this->success ('获取成功', '', $region);
    }


    public function journeyEdit($id = 0)
    {
        if (request ()->isGet ()) {
            $Card = \app\wycadmin\model\VipCard::all (function ($query){
                $query->field('title,card_id')->where('status','eq',1);
            });
            $Vehicle = \app\wycadmin\model\Vehicle::all (function ($query){
                $query->field('title,id')->where('status','eq',1);
            });
            $List = $this->getSonList(0,'Category','cid');
            $this->assign ([
                'List'=>$List,
                'Card'=>$Card,
                'Vehicle'=>$Vehicle
            ]);
            $journeyInfo = JourneyModel::get (['id' => $id]);
            //获取景点名称
            $scenic_name = ScenicModel::where(['id' => $journeyInfo->sc_id])->value('title');
            $this->assign(['scenic_name' => $scenic_name]); //景点名
            $this->assign (['info' => $journeyInfo]);

            return $this->fetch ();
        } elseif (request ()->isPost ()) {
            $data = input ('post.');
            if($data['cid'] > 2){
                //1 国外 2省外 3省内
                $data['card_id'] = 2;
            }else{
                $data['card_id'] = 1;
            }
            $this->validateCheck ('Journey', $data);
            try {
                $journeyInfo = JourneyModel::getInfo ([
                    'id' => $data['id']
                ], '*', true);
                if (!$journeyInfo) {
                    \exception ('修改信息不存在');
                }
                $sc = ScenicModel::getInfo ([
                    'id' => $data['sc_id']
                ], 'id,title');
                if (!$sc) {
                    \exception ('输入的景区编号不存在');
                }
                $journeyInfo::infoEdit ($journeyInfo, [
                    'sc_id', 's_time','e_time', 'create_time', 'update_time','week','year','month','vehicle_type','vehicle','mobile','max_people_count','cid','card_id','v_id','tickets_price','cash'
                ], $data);
                OperationRecord::recordAdd ($this->adminInfo, '修改了景区' . $sc->title . '的行程');
                Db::commit ();
            } catch (Exception $e) {
                Db::rollback ();
                return $this->error ($e->getMessage ());
            }
            return $this->success ('行程修改成功', "journey/journeylist", null, 2);
        }
    }


    /**
     * 修改
     */
    public function journeyStatusUpdate()
    {
        $data = request ()->post ();
        if (empty($data['id'])) {
            return $this->success ('操作成功', '', null, 2);
        }
        Db::startTrans ();
        try {
            $model = new JourneyModel();
            $this->adminUpdateStatus ($model, $data['id'], $data['status']);
            Db::commit ();
        } catch (Exception $e) {
            Db::rollback ();
            return $this->error ($e->getMessage ());
        }
        return $this->success ('操作成功', '', null, 2);
    }
}