<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/12
 * Time: 9:15
 */

namespace app\wycadmin\controller;

use app\common\controller\admin\AdminBase;
use app\wycadmin\model\Region as RegionModel;
use app\wycadmin\model\OperationRecord;
use think\Db;
use think\Exception;

class Region extends AdminBase
{
    /**
     * 地区列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function regionList($pid = 0){
        $list = RegionModel::getInfoPage([
            'status'=>['neq',$this->delete],
            'pid'=>['eq',$pid]
        ],'status,id,title,image_path,sort,pid,create_time,update_time','id DESC',$this->listRows);
        $this->assign (
            [
                'pid'=>$pid,
                'List'=>$list,
            ]
        );
        return $this->fetch();
    }


    //添加地区
    public function regionAdd($pid = 0){
        if (request ()->isGet ()){
            $List = $this->getSonList(0,'Region','pid');
            $this->assign (['List'=>$List,'pid'=>$pid]);
            return $this->fetch ();
        }else if(request ()->isPost ()){
            $data = input('post.');
            $this->validateCheck('Region',$data);
            Db::startTrans ();
            try{
                //$data['image_path'] = $this->fileUpload ('image',['jpg','png','jpeg'],'region','请上传地区图片');
                RegionModel::infoAdd ($data,[
                    'title','create_time','update_time','sort','pid'
                ]);
                OperationRecord::recordAdd ($this->adminInfo,'新增了地区'.$data['title']);
                Db::commit ();
            }catch (Exception $e){
                Db::rollback ();
                return $this->error ($e->getMessage ());
            }
            return $this->success ('地区添加成功',"region/regionlist?pid=".$pid,null,2);
        }
    }




    public function regionEdit($id = 0){
        if (request()->isGet()){
            $regionInfo = model ('Region')->get(['id'=>$id]);
            $this->assign(['info'=>$regionInfo]);
            $List = $this->getSonList(0,'Region','pid');
            $this->assign (['List'=>$List]);
            return $this->fetch();
        }elseif (request()->isPost()){
            $data = input('post.');
            $this->validateCheck('Region',$data);
            try{
                $regionInfo = RegionModel::getInfo ([
                    'id'=>$data['id']
                ],'*',true);
                if (!$regionInfo){
                    \exception ('地区不存在');
                }
                $regionInfo::infoEdit ($regionInfo,true,$data);
                OperationRecord::recordAdd ($this->adminInfo,'修改了地区'.$data['title']);
                Db::commit ();
            }catch (Exception $e){
                Db::rollback ();
                return $this->error ($e->getMessage ());
            }
            return $this->success ('地区修改成功',"region/regionlist?pid=".$data['pid'],null,2);
        }
    }


    /**
     * 修改
     */
    public function regionStatusUpdate(){
        $data = request ()->post ();
        if (empty($data['id'])){
            return $this->success ('操作成功','',null,2);
        }
        Db::startTrans ();
        try{
            $model = new RegionModel();
            $this->adminUpdateStatus ($model,$data['id'],$data['status'],'title');
            Db::commit ();
        }catch (Exception $e){
            Db::rollback ();
            return $this->error ($e->getMessage ());
        }
        return $this->success ('操作成功','',null,2);
    }
}