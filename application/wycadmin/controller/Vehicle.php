<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/12
 * Time: 9:15
 */

namespace app\wycadmin\controller;

use app\common\controller\admin\AdminBase;
use app\wycadmin\model\OperationRecord;
use app\wycadmin\model\Vehicle as VehicleModel;
use think\Db;
use think\Exception;

class Vehicle extends AdminBase
{
    /**
     * 交通工具列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function vehicleList($pid = 0){
        $list = VehicleModel::getInfoPage([
            'status'=>['neq',$this->delete],
        ],'status,id,title,create_time,update_time','id DESC',$this->listRows);
        $this->assign (
            [
                'pid'=>$pid,
                'List'=>$list,
            ]
        );
        return $this->fetch();
    }


    //添加交通工具
    public function vehicleAdd(){
        if (request ()->isGet ()){
            return $this->fetch ();
        }else if(request ()->isPost ()){
            $data = input('post.');
            $this->validateCheck('Vehicle',$data);
            Db::startTrans ();
            try{
                VehicleModel::infoAdd ($data,[
                    'title','create_time','update_time'
                ]);
                OperationRecord::recordAdd ($this->adminInfo,'新增了交通工具'.$data['title']);
                Db::commit ();
            }catch (Exception $e){
                Db::rollback ();
                return $this->error ($e->getMessage ());
            }
            return $this->success ('交通工具添加成功',"vehicle/vehiclelist",null,2);
        }
    }




    public function vehicleEdit($id = 0){
        if (request()->isGet()){
            $vehicleInfo = model ('Vehicle')->get(['id'=>$id]);
            $this->assign(['info'=>$vehicleInfo]);
            return $this->fetch();
        }elseif (request()->isPost()){
            $data = input('post.');
            $this->validateCheck('Vehicle',$data);
            try{
                $vehicleInfo = VehicleModel::getInfo ([
                    'id'=>$data['id']
                ],'*',true);
                if (!$vehicleInfo){
                    \exception ('交通工具不存在');
                }
                $vehicleInfo::infoEdit ($vehicleInfo,['title','update_time'],$data);
                OperationRecord::recordAdd ($this->adminInfo,'修改了交通工具'.$data['title']);
                Db::commit ();
            }catch (Exception $e){
                Db::rollback ();
                return $this->error ($e->getMessage ());
            }
            return $this->success ('交通工具修改成功',"vehicle/vehiclelist",null,2);
        }
    }


    /**
     * 修改
     */
    public function vehicleStatusUpdate(){
        $data = request ()->post ();
        if (empty($data['id'])){
            return $this->success ('操作成功','',null,2);
        }
        Db::startTrans ();
        try{
            $model = new VehicleModel();
            $this->adminUpdateStatus ($model,$data['id'],$data['status'],'title');
            Db::commit ();
        }catch (Exception $e){
            Db::rollback ();
            return $this->error ($e->getMessage ());
        }
        return $this->success ('操作成功','',null,2);
    }
}