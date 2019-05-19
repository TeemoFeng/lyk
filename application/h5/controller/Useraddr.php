<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/16
 * Time: 10:29
 */

namespace app\h5\controller;


use app\h5\model\Address;
use think\Db;
use think\Exception;

class Useraddr extends Base
{
    #地址列表
    public function addrList()
    {
        try {
            $addrList = Address::getAll ('id,addr,mobile,name,xiangxi,moren', [
                'uid' => $this->userId
            ], 'moren desc');
        } catch (Exception $e) {

        }
        $this->assign ([
            'addrList' => $addrList
        ]);
        return $this->fetch ();
    }

    //添加地址
    public function addAddr($oid = 0)
    {
        if (request ()->isGet ()) {
            return $this->fetch ();
        } elseif (request ()->isPost ()) {
            Db::startTrans ();
            try {
                $data = request ()->post ();
                $this->validateCheck ('Address', $data);
                $moren = isset($data['moren']) ? $data['moren'] : 0;
                $result = Address::infoAdd ([
                    'moren' => $moren,
                    'uid' => $this->userId,
                    'addr' => $data['addr'],
                    'xiangxi' => $data['xiangxi'],
                    'name' => $data['name'],
                    'mobile' => $data['mobile'],
                ], ['create_time', 'mobile', 'xiangxi', 'name', 'moren', 'uid', 'addr']);
                if ($oid != 0) {
                    $url = "order/details?id=" . $oid;
                } else {
                    $url = "useraddr/addrlist";
                }
                Db::commit ();
            } catch (Exception $e) {
                Db::startTrans ();
                return $this->error ($e->getMessage ());
            }
            return $this->success ('地址添加成功', $url);
        }
    }


    #默认地址
    public function morenaddress()
    {
        $address = model ('address')
            ->where ('uid', session ('user.uid'))
            ->where ('status', 0)
            ->find ();
        if ($address) {
            $address->allowField (true)->save (['status' => 1]);
        }
        return true;
    }


    #修改地址
    public function editAddr($id = 0,$oid='')
    {
        if (request ()->isGet ()) {
            try {
                $addrInfo = Address::getInfo ([
                    'id' => $id,
                    'uid' => $this->userId
                ]);
            } catch (Exception $e) {
                return $this->redirect ('index/index');
            }
            $this->assign ([
                'addrInfo' => $addrInfo
            ]);
            return $this->fetch ();
        } elseif (request ()->isPost ()) {
            Db::startTrans ();
            try {
                $data = request ()->post ();
                $this->validateCheck ('Address', $data);
                $addrInfo = Address::getInfo ([
                    'id'=>$data['id'],
                    'uid'=>$this->userId
                ],'*',true);
                if (!$addrInfo) {
                    \exception ('要修改的地址不存在');
                }
                Address::infoEdit ($addrInfo, ['addr', 'xiangxi', 'name', 'moren', 'mobile'], [
                    'uid' => $this->userId,
                    'addr' => $data['addr'],
                    'xiangxi' => $data['xiangxi'],
                    'name' => $data['name'],
                    'mobile' => $data['mobile'],
                ]);
                if ($oid != 0) {
                    $url = "order/details?id=" . $oid;
                } else {
                    $url = "useraddr/addrlist";
                }
                Db::commit ();
            }catch (Exception $e){
                Db::rollback ();
                return $this->error ($e->getMessage ());
            }
            return $this->success ('地址修改成功',$url);
        }

    }

    #删除地址
    public function addressdel($id = 0)
    {
        Db::startTrans ();
        try {
            $addr = Address::getInfo (['uid' =>$this->userId, 'id' => $id]);
            if (!$addr) {
                \exception('非法操作');
            }
            $addr->delete ();
            Db::commit ();
        } catch (Exception $e) {
            Db::rollback ();
            return $this->error ($e->getMessage ());
        }
        return $this->success ('地址已删除');
    }

    public function morenaddressupdate($id = 0)
    {
        $addr = Address::get (['uid' => session ('user.uid'), 'id' => $id]);
        if (!$addr) {
            return $this->error ('非法操作');
        }
        Db::startTrans ();
        try {
            $addr->allowField (true)->save (['moren' => 1]);
            Db::commit ();
        } catch (Exception $e) {
            Db::rollback ();
            return $this->error ('默认地址修改失败');
        }
        return $this->success ('默认地址已修改');
    }


}