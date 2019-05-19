<?php
/**
 * 首页控制器
 */
namespace app\h5\controller;


use app\h5\model\Banner;
use app\h5\model\Special;
use think\Exception;
use app\h5\model\Scenic;

class Index extends Base
{
    /**
     * 首页
     * @auther enfu
     * @date 2019/5/13 14:57
     */
    public function index()
    {
        $banner = Banner::getBannerInfo();
        $SpecialList = Special::getInfoPage ([
            'status'=>1,
            's_time'=>['<',time ()],
            'e_time'=>['>',time ()],
        ],'sc_id,id,s_time,e_time,heat,arrange','sort DESC',4);
        
        foreach ($SpecialList as &$v){
            //查询景点详情
            $sc_info = Scenic::where(['id' => $v->sc_id])->find();
            $v['title'] = $sc_info['title'];
            $v['img'] = $sc_info['image_path'];
        }

        return $this->fetch('',[
            'banner'=>$banner,
            'SpecialList' => $SpecialList,
        ]);
    }

    public function ajaxIndex(){
        if (request ()->isAjax ()){
            try{
                $SpecialList = Special::getInfoPage ([
                    'status'=>1,
                    's_time'=>['<',time ()],
                    'e_time'=>['>',time ()],
                ],'sc_id,id,s_time,e_time,heat,arrange','sort DESC',4);
            }catch (Exception $e){
                return $this->error ('获取失败','',null);
            }
            return $this->success ('获取成功','',$SpecialList);
        }
    }

    /**
     * 直通车
     * @return mixed
     * @auther enfu
     * @date 2019/5/13 16:22
     */
    public function indexActive()
    {
        return $this->fetch();
    }

    /**
     * 卡片激活
     * @auther enfu
     * @date 2019/5/13 16:28
     */
    public function indexJihuo()
    {
        return $this->fetch();
    }

    /**
     * 热门景区
     * @return mixed
     * @auther enfu
     * @date 2019/5/13 16:30
     */
    public function indexHot()
    {
        return $this->fetch();
    }


}