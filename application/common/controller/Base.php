<?php
/**
 * Created by PhpStorm.
 * User: aa
 * Date: 2019/1/17
 * Time: 20:08
 */

namespace app\common\controller;

use OSS\OssClient;
use think\Controller;
use think\Db;
use think\Exception;
class Base extends Controller
{
    /**
     * 当前控制器
     */
    protected $controller = null;
    protected $action = null;
    protected $delete = null;//config ('code.status_delete');
    protected $normal = null;//config ('code.status_normal');
    protected $padding = null;//config ('code.status_padding');
    protected $page = [];
    protected $angle = 1;

    protected function _initialize()
    {
        $this->page = [
            'query' => request()->param(),
        ];
        $this->delete = config ('code.status_delete');
        $this->normal = config ('code.status_normal');
        $this->padding = config ('code.status_padding');
    }
    protected function ztorsm($parent_id,$type){
        return model ('Member')->where('id',$parent_id)->setInc($type);
    }

    //重复验证

    protected function repeatCheck($modelName = '',$fieldName = '',$value = '',$msg){
        $check = model ($modelName)->field ('id')->where ($fieldName,$value)->where ('status',$this->normal)->find ();
        if ($check){
            return $this->error ($msg);
        }
        return;
    }

    /**
     * @param $validateName 验证器名
     * @param $data 要验证的数组
     * @throws \Exception
     */
    protected function validateCheck($validateName,$data){
        $validate = validate($validateName);
        if (!$validate->check($data)){
            return $this->error($validate->getError());
        }
    }

    protected function getPt($type){
        switch ($type){
            case 'dsjqb':
                return '大数据钱包';
                break;
            case 'djjf':
                return '资产钱包';
                break;
            case 'gwjf':
                return '购物钱包';
                break;
            case 'yebqb':
                return '余额宝钱包';
                break;
        }
    }


    protected function buyTongji($parentStr,$price = 0,$zt_buy){
        $parentArr = array_reverse (explode (',',substr ($parentStr,0,-1)));
        $result = true;
        foreach ($parentArr as $k=>$v){
            $info = model ('Member')->where ('id',$v)->find ();
            if ($info && $k == 0){
                        $jl = $price*$zt_buy*0.01/2;
                        if ($info->djjf_balance < $jl){
                            $sf = $info->djjf_balance;
                        }else{
                            $sf = $jl;
                        }
                        $result4 = $info->allowField (true)
                        ->isUpdate (true)
                        ->save (
                            [
                                'team_buy'=>$info->team_buy + $price,
                                'gwjf_balance'=>$info->gwjf_balance+ $jl,
                                'yebqb_balance'=>$info->yebqb_balance+ $sf,
                                'djjf_balance'=> $info->djjf_balance - $sf
                            ]
                        );
                    $result4 = $this->financeRecord ($info,$sf,'-','djjf_balance','直推会员购币释放');
                    $result2 = $this->financeRecord ($info,$jl,'+','gwjf_balance','直推会员购币赠送');
                    $result3 = $this->financeRecord ($info,$sf,'+','yebqb_balance','直推会员购币赠送');
                    if ($result2 && $result4 && $result3 && $result4){
                        $result1 = true;
                    }else{
                        $result1 = false;
                    }
            }elseif($info){
                $result1 = $info
                    ->allowField (true)
                    ->isUpdate (true)
                    ->save ([
                        'team_buy'=>$info->team_buy + $price,
                    ]);
            }else{
                $result1 = true;
            }
            if (!$result1){
                $result = false;
            }
        }
        return $result;
    }

    //更新重复验证

    protected function updateRepeatCheck($modelName = '',$fieldName = '',$value = '',$id,$msg){
        $check = model ($modelName)
            ->field ('id')
            ->where ($fieldName,$value)
            ->where ('id','neq',$id)
            ->where ('status',$this->normal)
            ->find ();
        if ($check){
            return $this->error ($msg);
        }
        return;
    }

    protected function getProductFirstImage($pid){
        $image = model ('Product')
            ->where ('id',$pid)
            ->value ('image');
        return Signatureurl($image);
    }

    //给上级发放奖励
    protected function parentJl($info,$price1 =0){
        if (!$info){
            return true;
        }
        $parentIdArr = explode (',',substr ($info->parent_idstr,0,-1));
        $parentIdArr = array_reverse ($parentIdArr);
        $where = [];
        $arr = [];
        $jd = 0;
        $result = true;
        foreach ($parentIdArr as $k=>$v){
            $parentInfo = model ('Member')
                ->where('id',$v)
                ->find ();
            if (!$parentInfo){
                continue;
            }
            $condition = model ('DirectpushReward')
                ->where ('dai','<=',$parentInfo->team_buy)
                ->where ($where)
                ->order ('dai DESC')
                ->find ();
            if ($condition){
                $price = ($price1/2)*(($condition->bili-$jd)*0.01);
                if ($info->djjf_balance < $price){
                    $sf = $info->djjf_balance;
                }else{
                    $sf = $price;
                }
                $result1 = $parentInfo->allowField (true)->isUpdate (true)
                    ->save (
                        [
                            'yebqb_balance'=>$parentInfo->yebqb_balance+$sf,
                            'gwjf_balance'=>$parentInfo->gwjf_balance+$price,
                            'djjf_balance'=> $parentInfo->djjf_balance - $sf
                        ]
                    );
                $result2 = $this->financeRecord ($parentInfo,$sf,'+','yebqb_balance','团队奖金');
                $result4 = $this->financeRecord ($parentInfo,$price,'+','gwjf_balance','团队奖金');
                $result3 = $this->financeRecord ($parentInfo,$sf,'-','djjf_balance','团队奖金释放');
                $where = [
                    'dai'=>['>',$condition->dai]
                ];
                $jd = $condition->bili;
                $arr[$k] = $price;
                if (!$result3 || !$result2 || !$result1 || !$result4){
                    $result = false;
                }
            }
        }
        return $result;
    }


    protected function fieldFilter($fieldStr,$data){
        foreach ($data as $key=>$value){
            if (stripos($fieldStr,$key) === false){
                unset($data[$key]);
            }else{
                continue;
            }
        }
        return $data;
    }



    protected  function getList($model,$fields,$fid = 0, $target = [])
    {
        $one = model($model)->field($fields)->where('parent_id', $fid)->select();
        static $n = 0; // 初始分类级别是1
        foreach ($one as $c) {
            // 第一次遍历
            // $c->id == 1;
            // $c->title == '体育';
            $c->level = $n; // 对象属性赋值
            $target[$c->id] = $c->toArray();
            $n++;
            $target = $this->getList($model,$fields,$c->id, $target);
            $n--;
        }
        return $target;
    }

    protected function uploadImage($dst, $getFile)
    {
        #配置OSS基本配置
        $config = array(
            'KeyId' => 'LTAIez2djWAJhBfp',
            'KeySecret' => '9pNfZsKrktFOiYzWboRdPgP5Mz9QB9',
            'Endpoint' => 'oss-cn-hongkong.aliyuncs.com',
            'Bucket' => 'acnacn',
        );
        $ossClient = new OssClient($config['KeyId'], $config['KeySecret'],
            $config['Endpoint']);
        #执行阿里云上传
        $result = $ossClient->uploadFile($config['Bucket'], $dst, $getFile);
        #返回
        return $result;
    }


    protected function fileUpload($filename,$validate = [],$folder = 'uploads',$noFileMsg = '请上传图片'){
        $file = request()->file($filename);
        if($file){
            $info = $file->validate($validate)->move(ROOT_PATH . 'public' . DS . $folder);
            if($info){
               return DS.$folder.DS.$info->getSaveName ();
            }else{
                \exception ($file->getError());
            }
        }
        \exception ($noFileMsg);
    }


    protected function base64_upload($imgBase64,$path = 'uploads')
    {
        //匹配出图片的格式
        if (preg_match ('/^(data:\s*image\/(\w+);base64,)/', $imgBase64, $result)) {
            $type = $result[2];
            $new_file = ROOT_PATH.'public'.DS.$path . "/" ;
            if (!file_exists ($new_file)) {
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir ($new_file, 0700);
            }
            $filename = date ('Ymd', time ()) . "/".time () . ".{$type}";
            $new_file = $new_file .$filename;
            if (file_put_contents ($new_file, base64_decode (str_replace ($result[1], '', $imgBase64)))) {
                return $filename;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }






    protected  function menuList(){
        $menuList = model('menu')
            ->field('title,id,controller,action')
            ->where('parent_id',0)
            ->order('sort DESC')
            ->select();
        foreach ($menuList as $k=>$v){
            $v->son = model('menu')
                ->field('title,id,controller,action')
                ->where('parent_id',$v->id)
                ->order('sort DESC')
                ->select();
        }
        return $menuList;
    }

    /**
     *获取数据状态
     * @param $status int 状态值
     * @return string 返回状态
     */
    protected function getStatus($status){
        switch ($status){
            case config ('code.status_delete'):
                return '删除';
                break;
            case config ('code.status_padding'):
                return '禁用';
                break;
            case config ('code.status_normal'):
                return '正常';
                break;
            default:
                return '没添加该状态请重新添加';
                break;
        }
    }

    /**
     * 判断当前时间是否在开始到结束时间范围之内
     * @param string $stime
     * @param string $etime
     * @return bool
     */
    protected function timeCheck($stime = '',$etime = ''){
        $stime = strtotime ($stime);
        $etime = strtotime ($etime);
        $time = strtotime (date ('H:i:s'));
        if ($time>=$stime && $time<=$etime){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param int $uid
     * @param int $price
     * @param string $plusormin
     * @param string $type
     * @param string $content
     * @return mixed
     * 财务流水记录
     */
    protected function financeRecord($userInfo,$price = 0,$plusormin = '+',$type = '',$content = ''){
        if ($price == 0){
            return true;
        }
        $data = [];
        $data['uid'] = $userInfo->id;
        $data['price'] = $price;
        $data['plusormin'] = $plusormin;
        $data['type'] = $type;
        $data['content'] = $content;
        $data['balance'] = $userInfo->$type;
        return model ('Finance')->data ($data)->allowField (true)->isUpdate (false)->save($data);
    }


    protected function financeRecord1($uid,$price = 0,$plusormin = '+',$type = '',$content = ''){
        $data = [];
        $data['uid'] = $uid;
        $data['price'] = $price;
        $data['plusormin'] = $plusormin;
        $data['type'] = $type;
        $data['content'] = $content;
        $data['balance'] = model ('Yeqb')->where ('uid',$uid)->where ('status',$this->normal)->sum ('balance');
        return model ('Finance')->data ($data)->allowField (true)->isUpdate (false)->save($data);
    }
}