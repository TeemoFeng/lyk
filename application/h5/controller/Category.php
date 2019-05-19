<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/15
 * Time: 12:53
 */

namespace app\h5\controller;


use app\common\controller\index\IndexBase;
use app\h5\model\Journey;
use \app\h5\model\Category as CategoryModel;
use think\Exception;
use app\common\model\Member;

class Category extends Base
{
    private $month = [
        '1'=>'一月',
        '2'=>'二月',
        '3'=>'三月',
        '4'=>'四月',
        '5'=>'五月',
        '6'=>'六月',
        '7'=>'七月',
        '8'=>'八月',
        '9'=>'九月',
        '10'=>'十月',
        '11'=>'十一月',
        '12'=>'十二月',
    ];

    public function categoryTypeController($cid = 0,$displayType = 0,$thisMonth = 0){
         try{
            if ($displayType == 0 || $displayType == 1 && $cid == 0){
                exception ('参数错误');
            }
            $jGroup = '';
           	
 
           
            if ($displayType == 1){
                if ($thisMonth == 0){
                    $thisMonth = date ('m');
                }
                $category = CategoryModel::getInfo ([
                    'status'=>1,
                    'id'=>$cid,
                    'display_type'=> 1
                ],'id');
                if (!$category){
                    exception ('不存在分类');
                }
                $order = 'week ASC';
                $jGroup = 'week';
                $field = 'week,year,month';
                $jWhere['month'] = ['eq',$thisMonth];
                $template = 'category/through_list';
            }elseif ($displayType == 2){
                $categorys = CategoryModel::where([
                  	'cid'	=> 1,
                    'status'=>1,
                    'display_type'=>2
                ])->order ('sort DESC')->column ('title','id');
                if (!empty($categorys) && $cid == 0){
                    $cid = key ($categorys);
                }elseif (!isset($categorys[$cid])){
                    $cid = 0;
                }
                $this->assign ([
                    'categorys'=>$categorys
                ]);
                $order = 'id desc';
                $field = 'id,sc_id';
                $template = 'category/destination_list';
            }
            $jWhere['year'] = date ('Y');
            $jWhere['status'] = ['eq',1];
            $jWhere['cid'] = ['eq',$cid];
            $journeys = Journey::all (function ($query) use($field,$jWhere,$order,$jGroup){
                $query->field($field)->where($jWhere)->order($order)->group($jGroup);
            });
            if ($displayType == 1){
                foreach ($journeys as $v){
                    $v->title = $v->year.'年'.$v->month.'月第'.$v->week.'周';
                    $jWhere['week'] = $v->week;
                    $v->son = Journey::getAll ('id,s_time,e_time,vehicle,sc_id',$jWhere,'week DESC');
                    foreach ($v->son as $journey){
                        $journey->csInfo = $journey->getScenic('image_path,title,intro')->find();
                    }
                }
            }else{
                foreach ($journeys as $journey){
                    $journey->csInfo = $journey->getScenic('image_path,title,intro')->find();
                }
            }
            $this->assign ([
                'journeys'=>$journeys,
                'thisMonth'=>$thisMonth,
                'month'=>$this->month,
                'cid'=>$cid,
                //'category'=>$categorys,
            ]);
            return $this->fetch($template);
        }catch (Exception $e){
           echo $e->getMessage ();
       }
    }

}