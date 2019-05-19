<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
if (\think\Request::instance()->isMobile()) {
    define('VIEW_PATH', __DIR__ . '/../application/index/view/mobile/');
} else {
    define('VIEW_PATH', __DIR__ . '/../application/index/view/pc/');
}

// 应用公共文件
function Signatureurl($file){
    $file = str_replace ("\\",'/',$file);
    $ak="LTAIez2djWAJhBfp";
    $sk="9pNfZsKrktFOiYzWboRdPgP5Mz9QB9";
    $domain="http://acnacn.oss-cn-hongkong.aliyuncs.com/";//图片域名或bucket域名
    $expire=time()+3600;
    $bucketname="acnacn";
    $StringToSign="GET\n\n\n".$expire."\n/".$bucketname."/".$file;

    $Sign=base64_encode(hash_hmac("sha1",$StringToSign,$sk,true));

    $url=$domain.urlencode($file)."?OSSAccessKeyId=".$ak."&Expires=".$expire."&Signature=".urlencode($Sign);

    return $url."\n";
}


//二维码
function createQRcode($savePath, $qrData = 'PHP QR Code :)', $qrLevel = 'L', $qrSize = 4, $savePrefix = 'qrcode')
{
    if (!isset($savePath)) return '';
    //设置生成png图片的路径
    $PNG_TEMP_DIR = $savePath;

    //检测并创建生成文件夹
    if (!file_exists($PNG_TEMP_DIR)) {
        mkdir($PNG_TEMP_DIR, 0777, true);
    }
    $filename = $PNG_TEMP_DIR . 'test.png';
    $errorCorrectionLevel = 'L';
    if (isset($qrLevel) && in_array($qrLevel, ['L', 'M', 'Q', 'H'])) {
        $errorCorrectionLevel = $qrLevel;
    }
    $matrixPointSize = 4;
    if (isset($qrSize)) {
        $matrixPointSize = min(max((int)$qrSize, 1), 10);
    }
    if (isset($qrData)) {
        if (trim($qrData) == '') {
            die('data cannot be empty!');
        }
        //生成文件名 文件路径+图片名字前缀+md5(名称)+.png
        $filename = $PNG_TEMP_DIR . $savePrefix . md5($qrData . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';
        //开始生成
        \PHPQRCode\QRcode::png($qrData, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
    } else {
        //默认生成
        \PHPQRCode\QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);
    }
    if (file_exists($PNG_TEMP_DIR . basename($filename)))
        return basename($filename);
    else
        return FALSE;
}

function getOrderCount($state = 1){
    $a = \app\common\model\Order::where('state',$state)->where ('uid',session ('user.uid'))->count ('id');
    if ($a != 0){
        return $a;
    }
    return '';
}