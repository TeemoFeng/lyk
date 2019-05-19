<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/14
 * Time: 9:24
 */

namespace app\wycadmin\controller;
use app\common\controller\admin\AdminBase;
use app\wycadmin\model\OperationRecord;
use app\wycadmin\model\Scenic as ScenicModel;
use app\wycadmin\model\ScenicImage;
use think\Db;
use think\Exception;

class Scenic extends AdminBase
{
    /**
     * 景点列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function scenicList($pid = 0){
        $list = ScenicModel::getInfoPage([
            'status'=>['neq',$this->delete],
        ],'status,addr,star,appoint_people,intro,id,title,create_time,update_time,category_id','id DESC',$this->listRows);
        foreach ($list as &$v){
            $name = \app\wycadmin\model\Category::where(['id' => $v->category_id])->value('title');
            $v->category_name = $name;
        }

        $this->assign (
            [
                'pid'=>$pid,
                'List'=>$list,
            ]
        );
        return $this->fetch();
    }



    //添加景点
    public function scenicAdd(){
        if (request ()->isGet ()){
            $region = \app\wycadmin\model\Region::getAll ('title,id',[
                'status'=>1,
                'pid'=>0
            ]);
            $this->assign ([
                'region'=>$region
            ]);
            //获取景点类型
            $category_list = $this->getSonList(0,'Category','cid');

            $this->assign(['category_list' => $category_list]);
            return $this->fetch ();
        }else if(request ()->isPost ()){
            $data = input('post.');
            $this->validateCheck('Scenic',$data);
            Db::startTrans ();
            try{
                $data['image_path'] = $this->fileUpload ('image',['jpg','png','jpeg'],'scenic','请上传景区列表图');
                $result = ScenicModel::infoAdd ($data,[
                    'title','create_time','update_time','addr','star','image_path','introduce','notice','circuit','intro','category_id'
                ]);
                $images = $this->fileUploads ('images',$result->id,'scenicBanner','请上传景区轮播图');
                $ScImg = new ScenicImage();
                $ScImg->allowField (['gl_id','image'])->isUpdate (false)->saveAll ($images);
                OperationRecord::recordAdd ($this->adminInfo,'新增了景点'.$data['title']);
                Db::commit ();
            }catch (Exception $e){
                Db::rollback ();
                return $this->error ($e->getMessage ());
            }
            return $this->success ('景点添加成功',"scenic/sceniclist",null,2);
        }
    }


    public function getRegionSon($pid = 0){
        $region = \app\wycadmin\model\Region::getAll ('title,id',[
            'status'=>1,
            'pid'=>$pid
        ]);
        return $this->success ('获取成功','',$region);
    }




    public function scenicEdit($id = 0){
        if (request()->isGet()){
            $region = \app\wycadmin\model\Region::getAll ('title,id',[
                'status'=>1
            ]);
            $this->assign ([
                'region'=>$region
            ]);
            //获取景点类型
            $category_list = $this->getSonList(0,'Category','cid');
            $this->assign(['category_list' => $category_list]);
            $scenicInfo = ScenicModel::get(['id'=>$id]);
            $this->assign(['info'=>$scenicInfo]);
            return $this->fetch();
        }elseif (request()->isPost()){
            $data = input('post.');
            $this->validateCheck('Scenic',$data);
            try{
                $scenicInfo = ScenicModel::getInfo ([
                    'id'=>$data['id']
                ],'*',true);
                if (!$scenicInfo){
                    \exception ('景点不存在');
                }
                if ($_FILES['image']['error'] == 0){
                    $data['image_path'] = $this->fileUpload ('image',['jpg','png','jpeg'],'scenic','请上传景区列表图');
                }
                $scenicInfo::infoEdit ($scenicInfo,[
                    'title','create_time','update_time','addr','star','image_path','introduce','notice','circuit','intro','category_id'
                ],$data);
                $files = request ()->file ('images');
                if (!empty($files)){
                    ScenicImage::imageDel($data['id']);
                    $ScImg = new ScenicImage();
                    $images = $this->fileUploads ('images',$data['id'],'scenicBanner','请上传景区轮播图');
                    $ScImg->allowField (['gl_id','image'])->isUpdate (false)->saveAll ($images);
                }
                OperationRecord::recordAdd ($this->adminInfo,'修改了景点'.$data['title']);
                Db::commit ();
            }catch (Exception $e){
                Db::rollback ();
                return $this->error ($e->getMessage ());
            }
            return $this->success ('景点修改成功',"scenic/sceniclist",null,2);
        }
    }


    /**
     * 修改
     */
    public function scenicStatusUpdate(){
        $data = request ()->post ();
        if (empty($data['id'])){
            return $this->success ('操作成功','',null,2);
        }
        Db::startTrans ();
        try{
            $model = new ScenicModel();
            $this->adminUpdateStatus ($model,$data['id'],$data['status'],'title');
            Db::commit ();
        }catch (Exception $e){
            Db::rollback ();
            return $this->error ($e->getMessage ());
        }
        return $this->success ('操作成功','',null,2);
    }
}