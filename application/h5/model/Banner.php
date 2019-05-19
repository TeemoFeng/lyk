<?php
/**
 * 首页 banner模型
 */

namespace app\h5\model;


class Banner extends \app\common\model\Banner
{
   public static function getBannerInfo()
   {
       return self::where('status','eq',1)->field('image_path')->select();
   }
}