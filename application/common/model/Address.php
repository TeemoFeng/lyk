<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/6
 * Time: 14:39
 */

namespace app\common\model;


class Address extends PublicModel
{
        protected static function init()
        {
           Address::afterWrite (function ($info){
              if ($info->moren == 1){
                  Address::where ('uid',session ('user.uid'))
                      ->where ('id','neq',$info->id)
                      ->where ('status',1)
                      ->setField (['moren'=>0]);
              }
           });
        }
}