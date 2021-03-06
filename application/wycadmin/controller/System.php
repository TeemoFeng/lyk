<?php
/**
 * Created by PhpStorm.
 * User: aa
 * Date: 2019/1/17
 * Time: 20:30
 */

namespace app\wycadmin\controller;



use app\common\controller\admin\AdminBase;
use app\common\lib\IAuth;
use think\Exception;
use think\Validate;

class System extends AdminBase
{
    /**
     * 该控制器会用到的Model名字
     */
    protected $MenuModelName = '';
    //protected $
    
    
    protected function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->MenuModelName = config('ModelName.Menu');
    }

    /**
     * 菜单列表
     * @return mixed
     */
    public function menuList($parentId = 0){
        $menuListPage = model ('menu')
            ->where ('parent_id',$parentId)
            ->where ('status','neq',-1)
            ->paginate ($this->listRows,false,$this->page)
        ->each (function ($item,$key){
            if($item->parent_id === 0){
                $item->fatherTitle = '顶级分类';
            }else{
                $item->fatherTitle = model ('menu')->where ('id',$item->parent_id)->value ('title');
            }
            return $item;
        });
        $this->assign (['menuListPage'=>$menuListPage,'parentId'=>$parentId]);
        return $this->fetch();
    }

    public function menuAdd($parentId = 0){
        if (request()->isGet()){
            $parentList = $this->getList('menu','title,id',0);
            $this->assign(['parentList'=>$parentList,'parentId'=>$parentId]);
            return $this->fetch();
        }elseif (request()->isPost()){
            $data = input('post.');
            $this->validateCheck($this->MenuModelName,$data);
            $Menu = model($this->MenuModelName);
            $this->publicAddOrEdit($this->editKey,$Menu,$data,'菜单添加','system/menulist');
        }
    }

    public function menuEdit($id = 0){
        if (request()->isGet()){
            $menuInfo = model ($this->MenuModelName)->get(['id'=>$id]);
            $parentList = $this->getList('menu','title,id',0);
            $this->assign(['parentList'=>$parentList,'menuInfo'=>$menuInfo]);
            return $this->fetch();
        }elseif (request()->isPost()){
            $data = input('post.');
            $this->validateCheck($this->MenuModelName,$data);
            $id = $data['id'];
            $data = IAuth::setStatus ($data);
            $Menu = model($this->MenuModelName);
            $this->publicAddOrEdit($this->editKey,$Menu,$data,'菜单编辑','system/menulist');
        }
    }

    /**
     * 删除菜单
     */
    public function menuDelete(){
        $this->publicModify($this->MenuModelName,$this->delete,'system/menulist');
    }
    /**
     * 禁用菜单
     */
    public function menuPadding(){
        $this->publicModify($this->MenuModelName,$this->padding,'system/menulist');
    }

    /**
     * 启用菜单
     */

    public function menuEnable(){
        $this->publicModify($this->MenuModelName,$this->normal,'system/menulist');
    }
}