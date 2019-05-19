<?php
namespace app\index\controller;
use think\Loader;

class Pay{
     public function lists(){

         Loader::import('pay.example.WxPay',EXTEND_PATH,'.JsApiPay.php');
         try{
             $tools = new \JsApiPay();

             $openId = $tools->GetOpenid();

             //②、统一下单
             $input = new \WxPayUnifiedOrder();
             $input->SetBody("test");        //商品描述
             //$input->SetAttach("test");    //附加数据暂未使用到可以注释掉
             $input->SetOut_trade_no("sdkphp".date("YmdHis"));//商户订单号,此处订单号根据实际项目中订单号进行赋值,要求32个字符内，只能是数字、大小写字母_-|* 且在同一个商户号下唯一
             $input->SetTotal_fee("1");      //订单总金额，单位为分
             $input->SetTime_start(date("YmdHis"));//订单生成时间，格式为yyyyMMddHHmmss，如2009年12月25日9点10分10秒表示为20091225091010
             $input->SetTime_expire(date("YmdHis", time() + 600));//订单失效时间，格式为yyyyMMddHHmmss，如2009年12月27日9点10分10秒表示为20091227091010。订单失效时间是针对订单号而言的，由于在请求支付的时候有一个必传参数prepay_id只有两小时的有效期，所以在重入时间超过2小时的时候需要重新请求下单接口获取新的prepay_id
             //$input->SetGoods_tag("test");//订单优惠标记，使用代金券或立减优惠功能时需要的参数,项目暂未使用到，因此注释掉
             $input->SetNotify_url("http://paysdk.weixin.qq.com/notify.php");//异步接收微信支付结果通知的回调地址，通知url必须为外网可访问的url，不能携带参数。
             $input->SetTrade_type("JSAPI");//交易类型JSAPI 公众号支付;NATIVE 扫码支付;APP APP支付;
             $input->SetOpenid($openId);
             $config = new \WxPayConfig();
             $order = \WxPayApi::unifiedOrder($config, $input);
             echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
             $this->printf_info($order);
             $jsApiParameters = $tools->GetJsApiParameters($order);

             //获取共享收货地址js函数参数
             $editAddress = $tools->GetEditAddressParameters();
             //将数据渲染到模板中或前端页面中
             $assign=array(
                 'data'=>$jsApiParameters
             );
             $this->assign($assign);
             $this->display('');
         } catch(Exception $e) {
             Log::ERROR(json_encode($e));//此处因为没有使用微信日志方法，所以暂未引入日志类
         }
     }
    public function printf_info($data){
//         echo 111;exit;
        foreach($data as $key=>$value){
            echo "<font color='#00ff55;'>$key</font> :  ".htmlspecialchars($value, ENT_QUOTES)." <br/>";
        }
    }
}