<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/12
 * Time: 9:15
 */

namespace app\wycadmin\controller;


use app\common\controller\admin\AdminBase;
use app\common\model\OrderPeopleInfo;
use app\common\model\ProductImage;
use app\common\model\ProductSize;
use think\Db;
use think\Exception;

class Product extends AdminBase
{
    public function productList(){
        $productListPage = model ('Product')
            ->where ('status','neq',$this->delete)
            ->paginate ($this->listRows,false,$this->page);
        $this->assign (['productList'=>$productListPage]);
        return $this->fetch();
    }

    public function productEdit($id = 0){
        if (request()->isGet()){
            $List = $this->getCategoryList ();
            $this->assign (['List'=>$List]);
            $productInfo = \app\common\model\Product::get ($id);
            $productInfo->size = $productInfo->ProductSize ()->select ();
           $productInfo = $productInfo->getData ();
            $this->assign(['info'=>$productInfo]);
            return $this->fetch();
        }else if(request ()->isPost ()){
            $data = input('post.');
            $data['id'] = 1;
            $this->validateCheck('Product',$data);
            if ($data['pc_image'] != ''){
                $pcimage = $this->base64_upload ($data['pc_image']);
                if (!$pcimage){
                    return $this->error ('PC端列表图上传失败');
                }
                $data['pc_image'] = $pcimage;
            }
            if ($data['yd_image'] != ''){
                $ydimage = $this->base64_upload ($data['yd_image']);
                if (!$ydimage){
                    return $this->error ('移动端列表图上传失败');
                }
                $data['yd_image'] = $pcimage;
            }
            Db::startTrans ();
            try{
                $arr = model ('Order')
                    ->alias ('o')
                    ->join ('OrderProduct op','o.id = op.oid')
                    ->field ('o.id')
                    ->where('op.pid','eq',$data['id'])
                    ->where('o.state','eq',1)
                    ->group('o.id')
                    ->column ('o.id');
                \app\common\model\Order::destroy ($arr);
                $result2 = model ('Card')
                    ->where ('pid','eq',$data['id'])
                    ->delete ();
                $result3 = model ('Collection')
                    ->where ('pid','eq',$data['id'])
                    ->delete ();
                $product = \app\common\model\Product::update($data,['id'=>$data['id']],true);
                $productImage = new ProductImage();
                if($_FILES['pcimage']['error'][0] === 0){
                    $pcimages = $this->fileUploads ('pcimage',['ext'=>'jpg,png,gif'],'pc',$product->id);
                    ProductImage::where([
                        'pid'=>$data['id'],
                        'type'=>'pc'
                    ])->delete ();
                    $productImage->data ($pcimage)->allowField (true)->isUpdate (false)->saveAll ($pcimages);
                }
                if($_FILES['ydimage']['error'][0] === 0){
                    $ydimage = $this->fileUploads ('ydimage',['ext'=>'jpg,png,gif'],'yd',$product->id);
                    ProductImage::where([
                        'pid'=>$data['id'],
                        'type'=>'yd'
                    ])->delete ();
                    $productImage->data ($pcimage)->allowField (true)->isUpdate (false)->saveAll ($ydimage);
                }
                $sdata = [];
                ProductSize::destroy (
                    [
                        'pid'=>$data['id']
                    ]
                );
                foreach ($data['size'] as $key=>$value){
                    $sdata[$key]['size'] = $value;
                    $sdata[$key]['price'] = $data['price'][$key];
                    $sdata[$key]['pid'] = $data['id'];
                }
                model ('ProductSize')->data($sdata)->allowField (true)->saveAll ($sdata);
                model ('OperationRecord')->allowField (true)->isUpdate (false)->save(
                    [
                        'aid'=>$this->adminId,
                        'content'=>'管理员'.$this->adminInfo->username.'编辑了商品'.$data['title']
                    ]
                );
                Db::commit ();
            }catch (Exception $e){
                Db::rollback ();
                return $this->error ($e->getMessage ());
            }
            return $this->success ('商品编辑成功','product/productlist');
        }
    }

    //添加商品
    public function productAdd(){
        if (request ()->isGet ()){
            $List = $this->getCategoryList ();
            $this->assign (['List'=>$List]);
            return $this->fetch ();
        }else if(request ()->isPost ()){
            $data = input('post.');
            $this->validateCheck('Product',$data);
            $pcimage = $this->base64_upload ($data['pc_image']);
            if (!$pcimage){
                return $this->error ('PC端列表图上传失败');
            }
            $data['pc_image'] = $pcimage;
            $ydimage = $this->base64_upload ($data['yd_image']);
            if (!$ydimage){
                return $this->error ('移动端列表图上传失败');
            }
            $data['yd_image'] = $pcimage;
            Db::startTrans ();
            try{
                $product = \app\common\model\Product::create ($data,true);
                $pcimages = $this->fileUploads ('pcimage',['ext'=>'jpg,png,gif'],$product->id);
                $ydimage = $this->fileUploads ('ydimage',['ext'=>'jpg,png,gif'],$product->id);
                $productImage = new ProductImage();
                $sdata = [];
                foreach ($data['size'] as $key=>$value){
                    $sdata[$key]['size'] = $value;
                    $sdata[$key]['price'] = $data['price'][$key];
                    $sdata[$key]['pid'] = $product->id;
                }
                model ('ProductSize')->data($sdata)->allowField (true)->saveAll ($sdata);
                $productImage->data ($pcimage)->allowField (true)->isUpdate (false)->saveAll ($pcimages);
                $productImage->data ($pcimage)->allowField (true)->isUpdate (false)->saveAll ($ydimage);
                model ('OperationRecord')->allowField (true)->isUpdate (false)->save(
                    [
                        'aid'=>$this->adminId,
                        'content'=>'管理员'.$this->adminInfo->username.'添加了商品'.$data['title']
                    ]
            );
                Db::commit ();
            }catch (Exception $e){
                Db::rollback ();
                return $this->error ($e->getMessage ());
            }
            return $this->success ('商品上传成功','product/productlist');
        }
    }


    private function getFiles(){
        foreach($_FILES as $file){
            $fileNum=count($file['name']);
            //return $this->error ($fileNum);
                for ($i=0; $i < $fileNum; $i++) {
                    $files[$i]['name']=$file['name'][$i];
                    $files[$i]['type']=$file['type'][$i];
                    $files[$i]['tmp_name']=$file['tmp_name'][$i];
                    $files[$i]['error']=$file['error'][$i];
                    $files[$i]['size']=$file['size'][$i];
                }
        }
    return $files;
}
    /**
     * 删除商品
     */
    public function productDelete(){
        $idarr = request ()->post ()['id'];
        Db::startTrans ();
        try{
            $arr = model ('Order')
                ->alias ('o')
                ->join ('OrderProduct op','o.id = op.oid')
                ->field ('o.id')
                ->where('op.pid','in',$idarr)
                ->where('o.state','eq',1)
                ->group('o.id')
                ->column ('o.id');
            \app\common\model\Order::destroy ($arr);
            $result2 = model ('Card')
                ->where ('pid','in',$idarr)
                ->delete ();
            $result3 = model ('Collection')
                ->where ('pid','in',$idarr)
                ->delete ();
            Db::commit ();
        }catch (Exception $e){
            Db::rollback ();
            return $this->error($e->getMessage ());
        }
        $this->publicModify('Product',$this->delete,'product/productlist');
    }
    /**
     * 禁用商品
     */
    public function productPadding(){
        $idarr = request ()->post ()['id'];
        Db::startTrans ();
        try{
            $arr = model ('Order')
                ->alias ('o')
                ->join ('OrderProduct op','o.id = op.oid')
                ->field ('o.id')
                ->where('op.pid','in',$idarr)
                ->where('o.state','eq',1)
                ->group('o.id')
                ->column ('o.id');
            \app\common\model\Order::destroy ($arr);
            $result2 = model ('Card')
                ->where ('pid','in',$idarr)
                ->delete ();
            $result3 = model ('Collection')
                ->where ('pid','in',$idarr)
                ->delete ();
            Db::commit ();
        }catch (Exception $e){
            Db::rollback ();
            return $this->error($e->getMessage ());
        }
        $this->publicModify('Product',$this->padding,'product/productlist');
    }

    /**
     * 启用商品
     */

    public function productEnable(){
        $this->publicModify('Product',$this->normal,'product/productlist');
    }
}