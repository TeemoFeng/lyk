<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/14
 * Time: 9:24
 */

namespace app\wycadmin\controller;

use app\common\controller\admin\AdminBase;
use app\wycadmin\model\Banner as BannerModel;
use app\wycadmin\model\OperationRecord;
use app\wycadmin\model\Scenic as ScenicModel;
use think\Db;
use think\Exception;

class Banner extends AdminBase
{
    /**
     * 轮播图列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function bannerList($pid = 0)
    {
        $list = BannerModel::getInfoPage ([
            'status' => ['neq', $this->delete],
        ], 'update_time,create_time,image_path,sc_id,id,status', 'id DESC', $this->listRows);
        $this->assign (
            [
                'pid' => $pid,
                'List' => $list,
            ]
        );
        return $this->fetch ();
    }


    //添加轮播图
    public function bannerAdd()
    {
        if (request ()->isGet ()) {
            return $this->fetch ();
        } else if (request ()->isPost ()) {
            $data = input ('post.');
//            $this->validateCheck ('Banner', $data); //去除景区编号验证
            Db::startTrans ();
            try {
//                $sc = ScenicModel::getInfo ([
//                    'id' => $data['sc_id']
//                ], 'id,title');
//                if (!$sc) {
//                    \exception ('输入的景区编号不存在');
//                }
                $data['image_path'] = $this->fileUpload ('image',['jpg','jepg','png'],'banner','请上传轮播图');
                $result = BannerModel::infoAdd ($data, [
                    'sc_id', 'image_path', 'create_time', 'update_time'
                ]);
                OperationRecord::recordAdd ($this->adminInfo, '新增了景区轮播图');
                Db::commit ();
            } catch (Exception $e) {
                Db::rollback ();
                return $this->error ($e->getMessage ());
            }
            return $this->success ('轮播图添加成功', "banner/bannerlist", null, 2);
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


    public function bannerEdit($id = 0)
    {
        if (request ()->isGet ()) {
            $bannerInfo = BannerModel::get (['id' => $id]);
            $this->assign (['info' => $bannerInfo]);
            return $this->fetch ();
        } elseif (request ()->isPost ()) {
            $data = input ('post.');
//            $this->validateCheck ('Banner', $data);
            try {
                $bannerInfo = BannerModel::getInfo ([
                    'id' => $data['id']
                ], '*', true);
                if (!$bannerInfo) {
                    \exception ('修改信息不存在');
                }
//                $sc = ScenicModel::getInfo ([
//                    'id' => $data['sc_id']
//                ], 'id,title');
//                if (!$sc) {
//                    \exception ('输入的景区编号不存在');
//                }
                if ($_FILES['image']['error'] == 0){
                    BannerModel::delImage ($data['image_path']);
                    $data['image_path'] = $this->fileUpload ('image',['jpg','jepg','png'],'banner','请上传轮播图');
                }
                $bannerInfo::infoEdit ($bannerInfo, [
                    'image_path','sc_id','update_time'
                    ], $data);
                OperationRecord::recordAdd ($this->adminInfo, '修改了景区的轮播图');
                Db::commit ();
            } catch (Exception $e) {
                Db::rollback ();
                return $this->error ($e->getMessage ());
            }
            return $this->success ('轮播图修改成功', "banner/bannerlist", null, 2);
        }
    }


    /**
     * 修改
     */
    public function bannerStatusUpdate()
    {
        $data = request ()->post ();
        if (empty($data['id'])) {
            return $this->success ('操作成功', '', null, 2);
        }
        Db::startTrans ();
        try {
            $model = new BannerModel();
            $this->adminUpdateStatus ($model, $data['id'], $data['status']);
            Db::commit ();
        } catch (Exception $e) {
            Db::rollback ();
            return $this->error ($e->getMessage ());
        }
        return $this->success ('操作成功', '', null, 2);
    }
}