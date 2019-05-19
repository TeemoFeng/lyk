<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/14
 * Time: 17:03
 */

namespace app\wycadmin\model;


class Journey extends \app\common\model\Journey
{
    public $modelName = '行程';

    public function setSTimeAttr($value){
        return strtotime ($value);
    }

    public function setETimeAttr($value){
        return strtotime ($value);
    }



    public function getWVehicleAttr($value,$data){
        switch ($data['vehicle']){
            case 0:
                return '普通预约';
                break;
            case 1:
                return $this->getZtcType ($data['vehicle_type']);
                break;
            default:
                return '未知类型';
                break;
        }
    }

    public function getZtcType($value){
        switch ($value){
            case 1:
                return '周六直通车';
                break;
            case 2:
                return '周日直通车';
                break;
            default:
                return '未知类型';
                break;
        }
    }
}