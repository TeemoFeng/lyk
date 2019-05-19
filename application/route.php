<?php
//// +----------------------------------------------------------------------
//// | ThinkPHP [ WE CAN DO IT JUST THINK ]
//// +----------------------------------------------------------------------
//// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
//// +----------------------------------------------------------------------
//// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
//// +----------------------------------------------------------------------
//// | Author: liu21st <liu21st@gmail.com>
//// +----------------------------------------------------------------------
//use think\Route;
//
//Route::any('index','h5/Index/index');
//Route::any('index_active','h5/Index/indexActive'); //活动景区
//Route::any('index_jihuo','h5/Index/indexJihuo'); //卡片激活
//Route::any('index_hot','h5/Index/indexHot'); //热门景区
//
//Route::any('trip','h5/Trip/index'); //行程首页
//Route::any('detail','h5/Trip/detail',['method'=>'get']); //详情页
//Route::any('trip_order/:id','h5/Trip/tripOrder',['method'=>'get']); //订单页
//
//
//Route::any('card','h5/Card/index'); //会员卡
//Route::any('card_active','h5/Card/cardActive'); //会员卡激活页
//
//
//Route::any('user','h5/UserCenter/index'); //个人中心
//Route::any('user_exchange','h5/UserCenter/userExchange'); //积分兑换
//Route::post('exchange','h5/UserCenter/exchange'); //兑换表单提交
//Route::any('user_exchange_record','h5/UserCenter/userExchangeRecord'); //兑换记录
//Route::any('user_card','h5/UserCenter/userCard'); // 用户会员卡
//Route::any('user_order','h5/UserCenter/userOrder'); // 用户旅行订单页
//Route::any('user_integral','h5/UserCenter/userIntegral'); // 用户积分
//Route::any('user_team','h5/UserCenter/userTeam'); // 我的团队
//Route::any('user_about','h5/UserCenter/userAbout'); // 关于我们
//Route::any('user_feedback','h5/UserCenter/userFeedback'); // 意见反馈
//Route::post('feedback','h5/UserCenter/feedback');  // 提交反馈
//Route::any('user_invite','h5/UserCenter/userInvite'); // 邀请分享
//
//Route::get('getUserInfo','h5/WeChat/getUserInfo'); // 微信网页授权回调地址
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];
