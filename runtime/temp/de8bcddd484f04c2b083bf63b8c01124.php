<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:72:"/www/wwwroot/lv.wyc168.com/public/../application/h5/view/user/index.html";i:1558080136;s:65:"/www/wwwroot/lv.wyc168.com/application/h5/view/public/header.html";i:1557896288;s:62:"/www/wwwroot/lv.wyc168.com/application/h5/view/public/nav.html";i:1557969048;s:65:"/www/wwwroot/lv.wyc168.com/application/h5/view/public/footer.html";i:1557906906;}*/ ?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <title>首页</title>

    <link href="/static/h5/css/mui.min.css" rel="stylesheet">
    <link href="/static/h5/css/swiper-3.4.2.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/static/h5/fonts/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/static/h5/css/swiper-3.4.2.min.css"/>
    <link rel="stylesheet" href="/static/h5/css/index.css">
</head>
	<style type="text/css">
		body,.mui-content{background: #fff;}
	</style>
	<body>
		<div class="mui-content mui-scroll-wrapper" id="pullrefresh">
			<div class="mui-scroll">	
				<div class="mui-table-view mui-table-view-chevron mui-index user   mui-bottom" >
					<div class="user_header">
						<div class="flex">
							
							<img src="/static/h5/images/tu2.jpg" alt="">
							
							<div class="">
								<p><?php echo $userInfo->username; ?></p>
								<p><?php echo $userInfo->mobile; ?> </p>
							</div>
						</div>
						<a href="<?php echo url('user/userExchange'); ?>"><img src="/static/h5/images/wode/duihuan.png" >兑换</a>
						<div class="user-num">邀请总人数：<?php echo $userInfo->zt_count; ?>人 <div class="mui-pull-right">总积分：<?php echo $userInfo->integral; ?></div></div>
					</div>
					<div class="user_center">
						<p>功能应用</p>
						<ul class="mui-list-unstyled mui-clearfix">
							<li>
								<a href="<?php echo url('vipcard/cardMakeOut'); ?>">
									<img src="/static/h5/images/wode/shimingrenzheng.png" alt="">
									<p>卡片转出</p>
								</a>
								
							</li>
							<li>
								<a href="<?php echo url('user/userCard'); ?>">
									<img src="/static/h5/images/wode/wodekabao.png" alt="">
									<p>我的卡包</p>
								</a>
								
							</li>
							<li>
								<a href="<?php echo url('user/userOrder'); ?>">
									<img src="/static/h5/images/wode/lvyoudingdan.png" alt="">
									<p>旅游订单</p>
								</a>
								
							</li>
							<li>
								<a href="<?php echo url('user/userTeam'); ?>">
									<img src="/static/h5/images/wode/wodetuandui.png" alt="">
									<p>我的团队</p>
								</a>
								
							</li>
							<li>
								<a href="<?php echo url('user/userIntegral'); ?>">
									<img src="/static/h5/images/wode/jifenjilu.png" alt="">
									<p>积分记录</p>
								</a>
								
							</li>
							<?php if($userInfo->valid): ?>
							<li>
								<a href="<?php echo url('user/userInvite'); ?>">
									<img src="/static/h5/images/wode/woyaofenxiang.png" alt="">
									<p>我要分享</p>
								</a>
								
							</li>
							<?php endif; ?>
							<li>
								<a href="<?php echo url('/user_about'); ?>">
									<img src="/static/h5/images/wode/guanyuwomen.png" alt="">
									<p>关于我们</p>
								</a>
								
							</li>
							<li>
								<a href="<?php echo url('useraddr/addrList'); ?>">
									<img src="/static/h5/images/wode/huiyuanxinxi.png" alt="">
									<p>实名认证</p>
								</a>
							</li>
							<li>
								<a href="<?php echo url('user/userFeedback'); ?>">
									<img src="/static/h5/images/wode/yijianfankui.png" alt="">
									<p>意见反馈</p>
								</a>
								
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<nav class="mui-bar mui-bar-tab offer-bottom">
    <a class="mui-tab-item mui-active" href="<?php echo url('index/index'); ?>">
        <img src="/static/h5/images/shouye.png" >
        <span class="mui-tab-label">首页</span>
    </a>

    <!-- <a class="mui-tab-item " href="xingcheng.html">
        <img src="/static/h5/images/xingcheng.png" >
        <span class="mui-tab-label">官网</span>
    </a> -->
    <a class="mui-tab-item " href="<?php echo url('vipcard/cardlist'); ?>">
        <img src="/static/h5/images/huiyuanka.png" >
        <span class="mui-tab-label">会员</span>
    </a>
    <a class="mui-tab-item" href="<?php echo url('user/index'); ?>">
        <img src="/static/h5/images/wode.png" >
        <span class="mui-tab-label">我的</span>
    </a>

</nav> 
		<script src="/static/h5/js/jquery-1.11.0.min.js"></script>
<script src="/static/h5/js/mui.js"></script>
<script src="/static/h5/js/index.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/h5/js/swiper-3.4.1.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/h5/js/ajax_Submit.js" type="text/javascript" charset="utf-8"></script> 
		<script type="text/javascript" charset="utf-8">
		mui.init({
				pullRefresh: {
					container: '#pullrefresh',
					down: {
						style:'circle',
						callback: pulldownRefresh
					}
				}
		});
		function pulldownRefresh() {
			setTimeout(function() {
				window.location.reload()
				mui('#pullrefresh').pullRefresh().endPulldownToRefresh(); //refresh completed
			}, 1500);
		}
		
			
		</script>
	
	</body>
</html>
