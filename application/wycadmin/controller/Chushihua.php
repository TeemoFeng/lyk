<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/7
 * Time: 17:38
 */

namespace app\wycadmin\controller;


use app\common\controller\admin\AdminBase;
use think\Db;
use think\Exception;

class Chushihua extends AdminBase
{
    public function chushihua(){
        return $this->fetch ();
    }

    public function chushihuazx(){
        try{
            $model = model('PublicModel');
            $model->query('truncate table wyc_address');
            $model->query('truncate table wyc_banner');
            $model->query('truncate table wyc_card');
            $model->query('truncate table wyc_category');
            $model->query('truncate table wyc_collection');
            $model->query('truncate table wyc_comment');
            $model->query('truncate table wyc_comment_image');
            $model->query('truncate table wyc_news');
            $model->query('truncate table wyc_news_type');
            $model->query('truncate table wyc_operation_record');
            $model->query('truncate table wyc_order');
            $model->query('truncate table wyc_order_product');
            $model->query('truncate table wyc_pd');
            $model->query('truncate table wyc_product');
            $model->query('truncate table wyc_product_image');
            $model->query('truncate table wyc_product_size');
            $this->success ('初始化成功');
        }catch (Exception $e){
            $this->success ($e->getMessage ());
        }
    }
  
   public function leijiqk(){
        return $this->fetch ();
    }

    public function qklj($type = ''){
        switch ($type){
            case 'star':
                $value = model ('StarClass')->field ('min(level_number)')->value ('level_number');
                break;
            default:
                $value = 0;
        }
        Db::startTrans ();
        try{
            $res1 = model ('Qktime')->allowField (true)->isUpdate (false)->save (
                [
                    'type'=>$type,
                ]
            );
            $res = model ('Member')->where('1=1')->setField ([$type=>$value]);
            if ($res && $res1){
                Db::commit ();
                return $this->success ('清除成功');
            }else{
                Db::rollback ();
                return $this->error('清除失败');
            }
        }catch (Exception $e){
            Db::rollback ();
            return $this->error('清除失败');
        }

    }
}