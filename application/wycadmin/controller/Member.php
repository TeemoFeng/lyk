<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/12
 * Time: 16:58
 */

namespace app\wycadmin\controller;


use app\common\controller\admin\AdminBase;
use think\Db;

class Member extends AdminBase
{
    protected $nojihuo = 0;
    protected $jihuo = 1;


    public function memberList($searchType = 'number',$parent_id = 0,$keyWord = '',$today='',$fid = 0){
      	if($today == 'today'){
        	$time='today';
          	$pwhere = '';
        }else{
        	$time='all';
          	if($fid != 0){
            	$pwhere=['id'=>$fid];
            }else{
            $pwhere=['parent_id'=>$parent_id];
            }
          	
        }
        if ($keyWord != ''){
            $pwhere = '';
        }
        $memberList = model ('Member')
            ->where ('status','eq',$this->normal)
          	->where($pwhere)
          	->whereTime('create_time',$time)
            ->where($searchType,'like','%'.$keyWord.'%')
            ->order ('id DESC')
            ->paginate ($this->listRows,false,$this->page)
            ->each (function ($item,$key){
                $item->level = model('level')
                    ->where ('level_number',$item->level)
                    ->value ('title');
                $item->yeqb_balance = model ('Yeqb')
                    ->where ('uid',$item->id)
                    ->where ('status',1)
                    ->sum ('balance');
                $parentInfo = model ('Member')->field ('mobile,number')->where ('id',$item->parent_id)->find ();
                if($parentInfo){
                    $item->parentinfo = $parentInfo->number.'('.$parentInfo->mobile.')';
                }else{
                    $item->parentinfo = '最上级会员';
                }
                //$item->status = $this->getStatus ($item->status);
                return $item;
            });
        $this->assign (['memberList'=>$memberList]);
        return $this->fetch();
    }
  
  
  
  

    public function memberAdd(){
        if (request ()->isGet ()){
            $memberNumber = $this->memberNumber ();
            $this->assign ('number',$memberNumber);
            return $this->fetch ();
        }else if(request ()->isPost ()){
            $data = input('post.');
            $this->validateCheck('Member',$data);
            $data['status'] = $this->normal;
            $data['level'] = model ('Level')->where ('status',$this->normal)->min ('level_number');
            $data['activation'] = $this->jihuo;
            $data = $this->getParentAdoptCode ($data['refereeCode'],$data);
            $newData = $this->fieldFilter('username,password,spassword,level,activation,number,status,mobile,parent_id,parent_idstr',$data);
            $newData['username'] = '';
            $newData['tj_code'] = '';
            try{
                $uid = model('Member')->add($newData);
                $result1 = true;//$this->registerJl($uid,$data['parent_id']);
                $result2 = $this->ztorsm ($newData['parent_id'],'zt_count');
                $result3 = $this->teamCount($newData['parent_idstr']);
                if ($uid && $result1 && $result2 && $result3){
                    $Model = model('Bank');
                    $this->publicAddOrEdit($this->editKey,$Model,[
                        'name'=>$data['name'],
                        'bank_mobile'=>$data['mobile'],
                        'uid'=>$uid,
                    ],'会员添加','member/memberlist','name',true);
                }
                return $this->error ('未知错误');
            }catch (Exception $e){
                return $this->error ($e->getMessage ());
            }

        }
    }


    private function teamCount($parent_str = ''){
        $parent_arr = explode (',',substr ($parent_str,0,-1));
        $result  =true;
        foreach ($parent_arr as $k=>$v){
            $info = model ('Member')->where ('id',$v)->find ();
            if ($info){
                $result2 =$info->allowField (true)->isUpdate (true)->save (
                    [
                        'team_count'=>$info->team_count + 1
                    ]
                );
               // return $this->error ($result2);
                if (!$result2){
                    $result = false;
                }
            }
        }
        return $result;
    }

    public function shenheList($keyWord = '',$searchType = 'mobile'){
        if (request()->isGet()){
            if ($keyWord !=''){
                $uid = model ('Member')->where ($searchType,$keyWord)->where ('status','neq',$this->delete)->value ('id');
                $where = ['uid'=>$uid];
            }else{
                $where = '';
            }
            $List = model('Renzheng')
                ->where('status',$this->normal)
                ->where ($where)
                ->order ('id ASC')
                ->paginate($this->listRows,false,$this->page)
                ->each(function ($item,$key){
                    $info = model('Member')->field('number,mobile,parent_id')->where('id',$item->uid)->find();
                    $item->uid = $info->number.'('.$info->mobile.')';
                    $parentInfo = model ('Member')
                        ->field ('mobile,number')
                        ->where ('id',$info->parent_id)
                        ->find ();
                    if ($parentInfo){
                        $item->parent = $parentInfo->number.'('.$parentInfo->mobile.')';
                    }else{
                        $item->parent = '没有推荐人';
                    }
                    return $item;
                });
            $this->assign(['List'=>$List]);

            return $this->fetch();
        }
    }


    public function shengheOk(){
        $data = request()->post();
        if (isset($data['type'])){
            $data['id'] = model ('Renzheng')
                ->where ('status',1)
                ->order ('id ASC')
                ->limit (0,100)
                ->column ('id');
        }
        $result = true;
        Db::startTrans();
        foreach ($data['id'] as $k=>$v){
            $id = $v;
            $shInfo = model('Renzheng')
                ->where('id',$id)
                ->where('status',$this->normal)
                ->find();
            if (!$shInfo){
                continue;
            }
            $memberInfo = model('Member')->where('id',$shInfo->uid)->find();
            if (!$memberInfo){
                continue;
            }
            try{
                $result1 =  $shInfo->allowField(true)
                    ->isUpdate(true)
                    ->save(
                        [
                            'status'=>$this->padding
                        ]
                    );
                $result6 = model('OperationRecord')
                    ->data([
                        'aid'=>$this->adminId,
                        'content'=>'管理员'.$this->adminInfo->username.'通过了用户'.$memberInfo->number.'的实名认证审核'
                    ])
                    ->allowField(true)
                    ->isUpdate(false)
                    ->save(
                        [
                            'aid'=>$this->adminId,
                            'content'=>'管理员'.$this->adminInfo->username.'通过了用户'.$memberInfo->number.'的实名认证审核'
                        ]
                    );
                $result2 = $this->registerJl($shInfo->uid,$memberInfo->parent_id);
                if (!$result1 || !$result6 || !$result2){
                    $result = false;
                    // return $this->error($result1);
                }
            }catch (Exception $e){
                break;
                $result = false;
            }
        }
        if ($result){
            Db::commit();
            return $this->success('审核已通过');
        }else{
            Db::rollback();
            return $this->error('审核失败');
        }

    }

    public function shengheBohui($id){
        $data = request()->post();
        Db::startTrans();
        $result = true;
        foreach ($data['id'] as $k=>$v){
            $id = $v;
            $shInfo = model('Renzheng')
                ->where('id',$id)
                ->where('status',$this->normal)
                ->find();
            if (!$shInfo){
                continue;
            }
            $username = model('Member')->where('id',$shInfo->uid)->value('number');
            try{
                $result2 = model('OperationRecord')
                    ->data([
                        'aid'=>$this->adminId,
                        'content'=>'管理员'.$this->adminInfo->username.'驳回了用户'.$username.'的实名认证审核'
                    ],true)
                    ->allowField(true)
                    ->isUpdate(false)
                    ->save(

                    );
                if (!$result2){
                    $result = false;
                }
            }catch (Exception $e){
                $result = false;
            }
        }
        $result5 = model('Renzheng')->where('id','in',$data['id'])->setField(['status'=>$this->delete]);
        if ($result && $result5){
            Db::commit();
            return $this->success('审核已驳回');
        }else {
            Db::rollback();
            return $this->error('审核驳回失败');
        }
    }


    private function registerJl($id,$parent_id){
        $info = model ('Member')
            ->where ('id',$id)
            ->find ();
        $ruleGive = model ('Rule')
            ->field ('idjjf,pdjjf')
            ->where ('id',1)
            ->find ();
        if ($info){
            $result1 = $info->allowField (true)
                ->isUpdate (true)
                ->save (
                    [
                        'djjf_balance'=>$info->djjf_balance+$ruleGive->idjjf
                    ]
                );
            $result3 = $this->financeRecord ($info,$ruleGive->idjjf,'+','djjf_balance','实名通过');
        }else{
            $result3 = true;
            $result1 = false;
        }
        $parentinfo = model ('Member')
            ->where ('id',$parent_id)
            ->find ();
        if ($parentinfo){
            $result2 = $parentinfo->allowField (true)
                ->isUpdate (true)
                ->save (
                    [
                        'djjf_balance'=>$parentinfo->djjf_balance+$ruleGive->pdjjf
                    ]
                );
            $result4 = $this->financeRecord ($parentinfo,$ruleGive->pdjjf,'+','djjf_balance','直推用户实名认证');
        }else{
            $result4 = true;
            $result2 = true;
        }
        if ($result2 && $result1 && $result3 && $result4){
            return true;
        }
        return false;
    }
   

    protected function getParentAdoptCode($code,$data){
        if (!empty($code)){
            $Parentinfo = model ('Member')
                ->where ('mobile',$code)
                ->where ('status','neq',$this->delete)
                ->find ();
            if(!$Parentinfo){
                return $this->error ('推荐人不存在');
            }
            $data['parent_id'] = $Parentinfo->id;
            $data['parent_idstr'] = $Parentinfo->parent_idstr.$Parentinfo->id.',';
            return $data;
        }else{
            $data['parent_id'] = 0;
            $data['parent_idstr'] = '0,';
            return $data;
        }
    }

    protected function memberNumber(){
        $qianzhui = model('Rule')->where('id',1)->value('number_qianzhui');
        $number = $qianzhui.mt_rand (100000,999999);
        $check = model ('Member')
            ->where('number',$number)
            ->find ();
        if ($check){
            $this->memberNumber ();
        }
        return $number;
    }

    /**
     * 加入黑名单
     */
    public function memberPadding(){
        $data = request ()->post ();
        $memberInfo = model ('Member')
            ->where ('id',$data['id'])
            ->where ('status',$this->normal)
            ->find ();
        if ($memberInfo){
            try{
                $result4 = model ('BlackName')->data ([
                    'id'=>$memberInfo->id,
                    'content'=>$data['content']
                ])->allowField (true)
                    ->isUpdate (false)->save ([
                        'id'=>$memberInfo->id,
                        'content'=>$data['content']
                    ]);
                $result5 = $memberInfo->allowField (true)->isUpdate (true)->save (['status'=>$this->padding]);
                if ($result5 && $result4){
                    return $this->success ('封禁成功');
                }
                return $this->success ('封禁失败');
            }catch (Exception $e){
                return $this->success ($e->getMessage ());
            }

        }
        return $this->success ('封禁成功');

    }

    public function memberEnable(){
        $id = request()->post()['id'][0];

        $result = model('BlackName')->where('id',$id)->delete();
        if($result){
            $this->publicModify('Member',$this->normal,'member/blacklist','number');
        }
        return $this->error('系统繁忙');
    }

    /**
     * 个人信息
     * @param $id
     * @return mixed
     */
    public function gerenxinxi($id = 0){
        $userInfo = model ('Member')
            ->field ('username,parent_id,number,mobile,level,id')
            ->where ('id',$id)
            ->find ();
        $bankInfo = model ('Bank')
            ->field ('bank_number,bank_name,name,ali,bank_addr')
            ->where ('uid',$id)
            ->find ();
        $userInfo->level = model ('Level')->where ('Level_number',$userInfo->level)->where ('status',$this->normal)->value ('title');
        $parentInfo = model ('Member')
            ->field ('mobile as username,number')
            ->where ('id',$userInfo->parent_id)
            ->find ();
        $this->assign (['userInfo'=>$userInfo,'bankInfo'=>$bankInfo,'parentInfo'=>$parentInfo]);
        return $this->fetch ();
    }



    public function userInfoEdit($id = 0){
        if (request ()->isPost ()){
            $data = input('post.');
            $checkArr1 = [
                '手机号' =>'mobile',
            ];
            $checkArr2 = [
                '支付宝' =>'ali',
                '银行卡号'=>'bank_number'
            ];
            $this->onlyCheck ($checkArr1,$data,'Member');
            $this->onlyCheck ($checkArr2,$data,'Bank');
            $this->validateCheck('UserInfo',$data);
            $ali = $this->base64_upload ($data['pingzheng']);
            $wechat = $this->base64_upload ($data['pingzheng1']);
            if ($ali != ''){
                $data['ali_image']  = $ali;
            }
            if ($wechat != ''){
                $data['wx_image'] = $wechat;
            }
            $data['bind'] = 1;
            $data['bank_mobile'] = $data['mobile'];
            model ('Bank')->edit($data,$data['bankid']);
            $Member = model('Member');
            $this->publicAddOrEdit($this->editKey,$Member,$data,'会员信息修改',"member/gerenxinxi?id=".$this->editKey,'number');
        }elseif (request ()->isGet ()){
            $userInfo = model ('Member')
                ->field ('username,parent_id,number,mobile,level,id')
                ->where ('id',$id)
                ->find ();
            $bankInfo = model ('Bank')
                ->field ('bank_number,bank_name,name,ali,bank_addr,id,usdt')
                ->where ('uid',$id)
                ->find ();
            $this->assign (['userInfo'=>$userInfo,'bankInfo'=>$bankInfo]);
            return $this->fetch ();
        }
    }

    /**
     * 唯一验证
     * @param array $checkNames
     * @param array $data
     * @param string $modelName
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function onlyCheck($checkNames = [],$data = [],$modelName = ''){
        foreach ($checkNames as $k=>$v){
            if($data[$v] != $data['old_'.$v]){
                $check = model ($modelName)
                    ->where ($v,$data[$v])
                    ->find ();
                if($check){
                    return $this->error ('该'.$k.'已注册');
                    exit;
                }
            }
        }
        return;
    }

    /**
     * 重置密码
     * @param int $id
     */
    public function resetPassword($id = 0){
        $password = 1234567;
        $spassword = 1234567;
        $data['password'] = $password;
        $data['spassword'] = $spassword;
        $Member = model ('member');
        $this->publicAddOrEdit($id,$Member,$data,'会员密码重置','member/gerenxinxi?id='.$id,'number');
    }


    /**
     * 黑名单列表
     */

    public function blackList($searchType = 'M.number',$keyWord = '',$time = ''){
        if($time != ''){
            $timearr = explode ('/',$time);
            $stime = $timearr[0];
            $etime = strtotime ($timearr[1])+86400;
            //var_dump($stime);
        }else{
            $stime = '2019-01-01';
            $etime = strtotime (date('Y-m-d'))+86400;
        }
        $memeberInfo = model ('Member')
            ->alias ('M')
            ->field ('username,parent_id,number,level,mobile,password,spassword,M.id,M.create_time,B.content')
            ->join ('BlackName B','M.id=B.id')
            ->where ('status',$this->padding)
            ->where($searchType,'like','%'.trim ($keyWord).'%')
            ->order ('id DESC')
            ->paginate ($this->listRows,false,$this->page)
            ->each (function ($item,$key){
                $parentInfo = model ('Member')->field ('mobile,number')->where ('id',$item->parent_id)->find ();
                if($parentInfo){
                    $item->parentinfo = $parentInfo->number.'('.$parentInfo->mobile.')';
                }else{
                    $item->parentinfo = '最上级会员';
                }
                $item->level = model ('Level')->where ('level_number',$item->level)->value ('title');
                return $item;
            });
        $this->assign (['memberList'=>$memeberInfo]);
        return $this->fetch ();
    }

    public function loginqt($id){
        session ('user_id',$id);
        cookie('user_id',$id);
        $this->redirect ('index/index/index');
    }

}