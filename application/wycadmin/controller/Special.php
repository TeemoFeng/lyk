<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/14
 * Time: 9:24
 */

namespace app\wycadmin\controller;

use app\common\controller\admin\AdminBase;
use app\wycadmin\model\Special as SpecialModel;
use app\wycadmin\model\OperationRecord;
use app\wycadmin\model\Scenic as ScenicModel;
use think\Db;
use think\Exception;

class Special extends AdminBase
{
    /**
     * 每周特价列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function specialList($pid = 0)
    {
        $list = SpecialModel::getInfoPage ([
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


    //添加每周特价
    public function specialAdd($id = 0)
    {
        if (request ()->isGet ()) {
            $Vehicle = \app\wycadmin\model\Vehicle::all (function ($query){
                $query->field('title,id')->where('status','eq',1);
            });
            $this->assign ([
                'Vehicle'=>$Vehicle
            ]);
            //获取景点名称
            $scenic_name = ScenicModel::where(['id' => $id])->value('title');
            $this->assign(['scenic_id' => $id]); //景点id
            $this->assign(['scenic_name' => $scenic_name]); //景点名
            return $this->fetch ();
        } else if (request ()->isPost ()) {
            $data = input ('post.');
            $this->validateCheck ('Special', $data);
            Db::startTrans ();
            try {
                $sc = ScenicModel::getInfo ([
                    'id' => $data['sc_id']
                ], 'id,title');
                if (!$sc) {
                    \exception ('输入的每周特价编号不存在');
                }
                SpecialModel::infoAdd ($data, [
                    'sc_id', 's_time','e_time', 'create_time', 'update_time','mobile','max_people_count','v_id','heat','arrange','sort'
                ]);
                OperationRecord::recordAdd ($this->adminInfo, '新增了每周特价' . $sc->title . '的每周特价');
                Db::commit ();
            } catch (Exception $e) {
                Db::rollback ();
                return $this->error ($e->getMessage ());
            }
            return $this->success ('每周特价添加成功', "special/speciallist", null, 2);
        }
    }



    public function getRegionSon($pid = 0)
    {
        $region = \app\wycadmin\model\Region::getAll ('title,id', [
            'status' => 1,
            'pid' => $pid
        ]);
        return $this->success ('获取成功', '', $region);
    }


    public function specialEdit($id = 0)
    {
        if (request ()->isGet ()) {
            $Vehicle = \app\wycadmin\model\Vehicle::all (function ($query){
                $query->field('title,id')->where('status','eq',1);
            });
            $this->assign ([
                'Vehicle'=>$Vehicle
            ]);
            $specialInfo = SpecialModel::get (['id' => $id]);
            //获取景点名称
            $scenic_name = ScenicModel::where(['id' => $specialInfo['sc_id']])->value('title');
            $this->assign(['scenic_name' => $scenic_name]); //景点名
            $this->assign (['info' => $specialInfo]);
            return $this->fetch ();
        } elseif (request ()->isPost ()) {
            $data = input ('post.');
            $this->validateCheck ('Special', $data);
            try {
                $specialInfo = SpecialModel::getInfo ([
                    'id' => $data['id']
                ], '*', true);
                if (!$specialInfo) {
                    \exception ('修改信息不存在');
                }
                $sc = ScenicModel::getInfo ([
                    'id' => $data['sc_id']
                ], 'id,title');
                if (!$sc) {
                    \exception ('输入的景区编号不存在');
                }
                $specialInfo::infoEdit ($specialInfo, [
                    'sc_id', 's_time','e_time', 'create_time', 'update_time','mobile','max_people_count','v_id','heat','arrange','sort'
                ], $data);
                OperationRecord::recordAdd ($this->adminInfo, '修改了每周特价' . $sc->title . '的每周特价');
                Db::commit ();
            } catch (Exception $e) {
                Db::rollback ();
                return $this->error ($e->getMessage ());
            }
            return $this->success ('每周特价修改成功', "special/speciallist", null, 2);
        }
    }


    /**
     * 修改
     */
    public function specialStatusUpdate()
    {
        $data = request ()->post ();
        if (empty($data['id'])) {
            return $this->success ('操作成功', '', null, 2);
        }
        Db::startTrans ();
        try {
            $model = new SpecialModel();
            $this->adminUpdateStatus ($model, $data['id'], $data['status']);
            Db::commit ();
        } catch (Exception $e) {
            Db::rollback ();
            return $this->error ($e->getMessage ());
        }
        return $this->success ('操作成功', '', null, 2);
    }
}