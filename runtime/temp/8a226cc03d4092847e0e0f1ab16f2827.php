<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:80:"/www/wwwroot/lv.wyc168.com/public/../application/h5/view/user/user_exchange.html";i:1557796954;s:65:"/www/wwwroot/lv.wyc168.com/application/h5/view/public/header.html";i:1557896288;s:65:"/www/wwwroot/lv.wyc168.com/application/h5/view/public/footer.html";i:1557906906;}*/ ?>
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
	<title>积分兑换</title>
	<body>
		<header class="mui-bar mui-bar-nav  index-headers">
			<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left color" href='javascript:;' ></a>
			<h1 class="mui-title color">积分兑换</h1>
			
		</header>
		<div class="mui-content mui-scroll-wrapper" id="pullrefresh" style="background: #fff;">
			<div class="mui-scroll">
				
				<div class="mui-table-view mui-table-view-chevron   jf_duihuan " >
					<div class="team_header">
						<div class="flex">
							
							<div class="flex-item mui-text-left">
								<p class="mui-bai">我的积分</p>
								<p class="mui-bai font15" style="font-size: 24px;">15313</p>
							</div>
						</div>
					</div>
					<div class="duihuan_main">
						<form class="mui-input-group">
							<div class="mui-input-row">
								<label class="blue">提现方式</label>
							</div>
							<div class="mui-input-row flex" style="padding-left: 13px;">
								<div class=" mui-radio mui-left flex-item">
									<label>银行卡</label>
									<input name="radio1" type="radio" value="0" checked >
								</div> 
								<div class=" mui-radio mui-left flex-item">
									<label>微信</label>
									<input name="radio1" type="radio" value="1">
								</div> 
								<div class=" mui-radio mui-left flex-item">
									<label>支付宝</label>
									<input name="radio1" type="radio" value="1">
								</div> 
							</div>	
							<div class="mui-input-row">
								<label class="blue">提现积分</label>
							</div>
							<div class="mui-input-row">
								
								<input type="text" class="mui-input-clear" name="num" placeholder="请输入提现数量">
							</div>
							<div class="mui-input-row">
								<label class="blue">银行卡</label>
							</div>
							<div class="mui-input-row">
							
								<input type="text" class="mui-input-clear" name="bank" placeholder="请输入银行卡号">
							</div>

							<button type="button" id="submite" class="mui-btns" >确定</button>
							<a href="<?php echo url('/user_exchange_record'); ?>" class="mui-pull-right blue" style="margin-top: -10px;">提现记录</a>
						</form>
					</div>
				</div>
				
			</div>
		</div>

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
		$('#submite')[0].addEventListener('tap',function(){
			var data=$('form').serializeArray()
			console.log(data)
			if(data[1].value==''||data[1].value==null){mui.toast('提现数量不能为空'); return false}
			if(data[2].value==''||data[3].value==null){mui.toast('银行卡号不能为空'); return false}
			
		})
			
		</script>
		
	</body>
</html>
