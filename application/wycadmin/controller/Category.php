<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/12
 * Time: 9:15
 */

namespace app\wycadmin\controller;

use app\common\controller\admin\AdminBase;
use app\wycadmin\model\Category as CategoryModel;
use app\wycadmin\model\OperationRecord;
use think\Db;
use think\Exception;

class Category extends AdminBase
{
    /**
     * 分类列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function categoryList(){
        $list = CategoryModel::getInfoPage([
            'status'=>['neq',$this->delete]
        ],'status,id,title,content,display_type,image_path,sort,cid,create_time,update_time','id DESC',$this->listRows);
        $this->assign (
            [
                'categoryList'=>$list,
            ]
        );
        return $this->fetch();
    }


    //添加分类
    public function categoryAdd(){
        if (request ()->isGet ()){
            $List = $this->getSonList(0,'Category','cid');
            $this->assign (['List'=>$List]);
            return $this->fetch ();
        }else if(request ()->isPost ()){
            $data = input('post.');
            $this->validateCheck('Category',$data);
            Db::startTrans ();
            try{
                $data['image_path'] = $this->fileUpload ('image',['jpg','png','jpeg'],'category','请上传分类图片');
                CategoryModel::infoAdd ($data,[
                    'title','image_path','display_type','content','create_time','update_time','sort','cid'
                ]);
                OperationRecord::recordAdd ($this->adminInfo,'新增了分类'.$data['title']);
                Db::commit ();
            }catch (Exception $e){
                Db::rollback ();
                return $this->error ($e->getMessage ());
            }
            return $this->success ('分类添加成功','category/categorylist',null,2);
        }
    }




    public function categoryEdit($id = 0){
        if (request()->isGet()){
            $categoryInfo = model ('Category')->get(['id'=>$id]);
            $this->assign(['info'=>$categoryInfo]);
            $List = $this->getSonList(0,'Category','cid');
            $this->assign (['List'=>$List]);
            return $this->fetch();
        }elseif (request()->isPost()){
            $data = input('post.');
            $this->validateCheck('Category',$data);
            try{
                $categoryInfo = CategoryModel::getInfo ([
                    'id'=>$data['id']
                ],'*',true);
                if (!$categoryInfo){
                    \exception ('分类不存在');
                }
                if ($_FILES['image']['error'] == 0){
                    $data['image_path']  = $this->fileUpload ('image',['png','jpg','jepg'],'category');
                }
                $categoryInfo::infoEdit ($categoryInfo,[
                    'title','image_path','display_type','content','create_time','update_time','sort','cid'
                ],$data);
                OperationRecord::recordAdd ($this->adminInfo,'修改了分类'.$data['title']);
                Db::commit ();
            }catch (Exception $e){
                Db::rollback ();
                return $this->error ($e->getMessage ());
            }
            return $this->success ('分类修改成功','category/categorylist',null,2);
        }
    }


    /**
     * 修改
     */
    public function categoryStatusUpdate(){
        $data = request ()->post ();
        if (empty($data['id'])){
            return $this->success ('操作成功','',null,2);
        }
        Db::startTrans ();
        try{
            $model = new CategoryModel();
            $this->adminUpdateStatus ($model,$data['id'],$data['status'],'title');
            Db::commit ();
        }catch (Exception $e){
            Db::rollback ();
            return $this->error ($e->getMessage ());
        }
        return $this->success ('操作成功','',null,2);
    }
}