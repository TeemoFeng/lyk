<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/7
 * Time: 13:01
 */

namespace app\wycadmin\controller;


use app\common\controller\admin\AdminBase;
use think\Exception;

class Order extends AdminBase
{
    public function orderList($searchType = '',$keyWord = ''){
        if ($searchType == 'oid'){
            $where = [
                'oid'=>$keyWord
            ];
        }elseif ($searchType =='uid'){
            $uid = model ('Member')->where ('number',$keyWord)->value ('id');
            $where = [
                'uid'=>$uid
            ];
        }else{
            $where = '';
        }
        $list = model ('Order')
            ->field ('id,order_number,payment_time,uid,name,addr,mobile,state')
            ->where ('state','neq',1)
            ->where ($where)
            ->order('state ASC,id DESC')
            ->paginate ($this->listRows,false,$this->page)
            ;
        $this->assign ([
            'List'=>$list
        ]);
        return $this->fetch ();
    }

    public function fahuo($oid = 0){
        $info = model ('Order')
            ->where ('id',$oid)
            ->where ('state',2)
            ->find ();
        if (!$info){
            return $this->error ('订单不存在');
        }
        try{
            $result = $info->allowField(true)->save([
                'state'=>3
            ]);
            if ($result){
                return $this->success ('发货成功');
            }
            return $this->error ('操作失败');
        }catch (Exception $e){
            return $this->error ($e->getMessage ());
        }
    }

    public function orderInfo($id = 0){
        $info = model ('Order')
            ->field ('id')
            ->where ('id',$id)
            ->find ();
        if (!$info){
            return $this->error ('没有查找到该订单');
        }
        $info->product = $info->OrderProduct()->select();
        foreach ($info->product as $k=>$v){
            $v->title = $v->product()->find()->title;
        }
       return $this->success('','',$info->product);
    }
}