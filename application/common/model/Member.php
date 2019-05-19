<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/13
 * Time: 9:18
 */

namespace app\common\model;


class Member extends PublicModel
{

    protected $updateTime = false;

    private function randCode($length = 34) {
        // 密码字符集，可任意添加你需要的字符
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
        for ( $i = 0; $i < $length; $i++ )
        {
            $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        return $password;
    }





    protected function setTjCodeAttr(){
        $d = $this->code();
        if(!(model('Member')->field('tj_code')->where('tj_code',$d)->find())){
            return $d;
        }else{
            $this->setTjCodeAttr();
        }
    }

    protected function code(){
        $code = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $rand = $code[rand(0,strlen($code))]
            .strtoupper(dechex(date('m')))
            .date('d')
            .substr(time(),-5)
            .substr(microtime(),2,5)
            .sprintf('%02d',rand(0,99));
        for(
            $a = md5( $rand, true ),
            $s = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            $d = '',
            $f = 0;
            $f < 6;
            $g = ord( $a[ $f ] ),
            $d .= $s[ ( $g ^ ord( $a[ $f + 8 ] ) ) - $g & 0x1F ],
            $f++
        );
        return $d;
    }

    public static function getMemberInfo($id){
        return  Member::get ($id);
    }
}