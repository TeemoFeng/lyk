<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/12
 * Time: 9:15
 */

namespace app\wycadmin\controller;


use app\common\controller\admin\AdminBase;

class News extends AdminBase
{
    public function newsList(){
        $newsListPage = model ('News')
            ->where ('status','neq',$this->delete)
            ->paginate ($this->listRows,false,$this->page)
            ->each (function ($item,$key){
                $item->status = $this->getStatus ($item->status);

                return $item;
            });
        $this->assign (['newsList'=>$newsListPage]);
        return $this->fetch();
    }

    public function newsEdit($id = 0){
        if (request()->isGet()){
            $newsInfo = model ('News')->get(['id'=>$id]);
            $this->assign(['newsInfo'=>$newsInfo]);
            return $this->fetch();
        }elseif (request()->isPost()){
            $data = input('post.');
            $data['status'] = $this->normal;
            if ($_FILES['image']['error'] != 4){
                $data['image']  = $this->fileUpload ('image');
                if ($data['image'] == ''){
                    return $this->error ('图片上传失败');
                }
            }
            //$this->validateCheck('News',$data);
            $NewsType = model('News');
            $this->publicAddOrEdit($this->editKey,$NewsType,$data,'新闻编辑','news/newslist');
        }
    }

    //添加新闻
    public function newsAdd(){
        if (request ()->isGet ()){
            return $this->fetch ();
        }else if(request ()->isPost ()){
            $data = input('post.');
            //$this->validateCheck('News',$data);
            $data['image'] = $this->fileUpload ('image');
            if ($data['image'] == ''){
                return $this->error ('图片上传失败');
            }
            $data['status'] = $this->normal;
            //$newData = $this->fieldFilter('username,password,status,power',$data);
            $News = model('News');
            $this->publicAddOrEdit($this->editKey,$News,$data,'新闻添加','news/newslist','title',true);
        }
    }
    /**
     * 删除新闻
     */
    public function newsDelete(){
        $this->publicModify('News',$this->delete,'news/newslist');
    }
    /**
     * 禁用新闻
     */
    public function newsPadding(){
        $this->publicModify('News',$this->padding,'news/newslist');
    }

    /**
     * 启用新闻
     */

    public function newsEnable(){
        $this->publicModify('News',$this->normal,'news/newslist');
    }
}