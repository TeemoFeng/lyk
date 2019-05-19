<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/14
 * Time: 9:24
 */

namespace app\wycadmin\controller;

use app\common\controller\admin\AdminBase;
use app\wycadmin\model\VipCard as VipCardModel;
use app\wycadmin\model\OperationRecord;
use app\wycadmin\model\Scenic as ScenicModel;
use think\Db;
use think\Exception;

class VipCard extends AdminBase
{
    /**
     * 旅游卡列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function vipCardList()
    {
        $list = VipCardModel::getInfoPage ([
            'status' => ['neq', $this->delete],
        ], '*', 'id DESC', $this->listRows);
        $this->assign (
            [
                'List' => $list,
            ]
        );
        return $this->fetch ();
    }


    //添加旅游卡
    public function vipCardAdd()
    {
        if (request ()->isGet ()) {
            return $this->fetch ();
        } else if (request ()->isPost ()) {
            $data = input ('post.');
            $this->validateCheck ('VipCard', $data);
            Db::startTrans ();
            try {
                $idCheck = \app\wycadmin\model\VipCard::getValue ([
                    'card_id'=>$data['card_id'],
                    'status'=>['neq',-1]
                ]);
                if ($idCheck){
                    \exception ('该卡片id已存在');
                }
                $data['image_path'] = $this->fileUpload ('image',['jpg','jepg','png'],'vipCard','请上传旅游卡图片');
                VipCardModel::infoAdd ($data, [
                    'card_id','title','price','card_type','card_type_number','recommend_award_type','recommend_award_price_up','recommend_award_price_down','update_time','open','create_time','image_path','strategy','introduce'
                ]);
                OperationRecord::recordAdd ($this->adminInfo, '新增了旅游卡'.$data['title']);
                Db::commit ();
            } catch (Exception $e) {
                Db::rollback ();
                return $this->error ($e->getMessage ());
            }
            return $this->success ('旅游卡添加成功', "vipcard/vipCardlist", null, 2);
        }
    }




    public function vipCardEdit($id = 0)
    {
        if (request ()->isGet ()) {
            $vipCardInfo = VipCardModel::get (['id' => $id]);
            $this->assign (['info' => $vipCardInfo]);
            return $this->fetch ();
        } elseif (request ()->isPost ()) {
            $data = input ('post.');
            $this->validateCheck ('VipCard', $data);
            try {
                $vipCardInfo = VipCardModel::getInfo ([
                    'id' => $data['id']
                ], '*', true);
                if (!$vipCardInfo) {
                    \exception ('修改信息不存在');
                }
                if ($vipCardInfo->card_id != $data['card_id']){
                    $idCheck = \app\wycadmin\model\VipCard::getValue ([
                        'card_id'=>$data['card_id'],
                        'status'=>['neq',-1]
                    ]);
                    if ($idCheck){
                        \exception ('该卡片id已存在');
                    }
                }
                if ($_FILES['image']['error'] == 0){
                    VipCardModel::delImage ($data['image_path']);
                    $data['image_path'] = $this->fileUpload ('image',['jpg','jepg','png'],'vipCard','请上传旅游卡图片');
                }
                $vipCardInfo::infoEdit ($vipCardInfo,[
                    'card_id','title','price','card_type','card_type_number','recommend_award_type','recommend_award_price_up','recommend_award_price_down','update_time','open','create_time','image_path','strategy','introduce'
                ], $data);
                OperationRecord::recordAdd ($this->adminInfo, '编辑了旅游卡'.$data['title']);
                Db::commit ();
            } catch (Exception $e) {
                Db::rollback ();
                return $this->error ($e->getMessage ());
            }
            return $this->success ('旅游卡修改成功', "vipcard/vipCardlist", null, 2);
        }
    }


    /**
     * 修改
     */
    public function vipCardStatusUpdate()
    {
        $data = request ()->post ();
        if (empty($data['id'])) {
            return $this->success ('操作成功', '', null, 2);
        }
        Db::startTrans ();
        try {
            $model = new VipCardModel();
            $this->adminUpdateStatus ($model, $data['id'], $data['status'],'title');
            Db::commit ();
        } catch (Exception $e) {
            Db::rollback ();
            return $this->error ($e->getMessage ());
        }
        return $this->success ('操作成功', '', null, 2);
    }
}