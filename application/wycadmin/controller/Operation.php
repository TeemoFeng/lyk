<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/12
 * Time: 16:17
 */

namespace app\wycadmin\controller;


use app\common\controller\admin\AdminBase;
use think\Config;
use think\Db;
use think\Exception;

class Operation extends AdminBase
{
    public function recordList(){
        $recordList = model ('OperationRecord')
            ->order ('id DESC')
            ->paginate ($this->listRows,false,$this->page)
            ->each (function ($item,$key){
                $item->aid = model ('AdminUser')->where('id',$item->aid)->value ('username');
                return $item;
            });
        $this->assign ('recordList',$recordList);
        return $this->fetch ();
    }

    public function deleteAll(){
        try{
            Db::query ('truncate table '.Config::get ('database.prefix').'operation_record');
            return $this->success ('记录以全部清空','operation/recordlist');
        }catch (Exception $e){
            return $this->error ($e->getMessage ());
        }
    }
}