<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/12
 * Time: 10:42
 */

namespace app\wycadmin\controller;


use app\common\controller\admin\AdminBase;

class Newstype extends AdminBase
{
    public function newstypeList(){
        $newstypeListPage = model ('NewsType')
            ->where ('status','neq',$this->delete)
            ->paginate ($this->listRows,false,$this->page)
            ->each (function ($item,$key){
                $item->status = $this->getStatus ($item->status);
                return $item;
            });
        $this->assign (['newstypeList'=>$newstypeListPage]);
        return $this->fetch();
    }

    //添加分类
    public function newstypeAdd(){
        if (request ()->isGet ()){
            return $this->fetch ();
        }else if(request ()->isPost ()){
            $data = input('post.');
            $this->validateCheck('NewsType',$data);
            $data['status'] = $this->normal;
            //$newData = $this->fieldFilter('username,password,status,power',$data);
            $News = model('NewsType');
            $this->publicAddOrEdit($this->editKey,$News,$data,'新闻类型添加','newstype/newstypelist','title',true);
        }
    }

    public function newstypeEdit($id = 0){
        if (request()->isGet()){
            $newstypeInfo = model ('NewsType')->get(['id'=>$id]);
            $this->assign(['newstypeInfo'=>$newstypeInfo]);
            return $this->fetch();
        }elseif (request()->isPost()){
            $data = input('post.');
            $this->validateCheck('NewsType',$data);
            $NewsType = model('NewsType');
            $this->publicAddOrEdit($this->editKey,$NewsType,$data,'新闻类型编辑','newstype/newstypelist');
        }
    }


    /**
     * 删除新闻分类
     */
    public function newstypeDelete(){
        $this->publicModify('NewsType',$this->delete,'newstype/newstypelist');
    }
    /**
     * 禁用新闻分类
     */
    public function newstypePadding(){
        $this->publicModify('NewsType',$this->padding,'newstype/newstypelist');
    }

    /**
     * 启用新闻分类
     */

    public function newstypeEnable(){
        $this->publicModify('NewsType',$this->normal,'newstype/newstypelist');
    }
}