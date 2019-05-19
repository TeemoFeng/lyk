<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:77:"/www/wwwroot/lv.wyc168.com/public/../application/h5/view/user/user_order.html";i:1557971072;s:65:"/www/wwwroot/lv.wyc168.com/application/h5/view/public/header.html";i:1557896288;}*/ ?>
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
	<style>
		html,
		body {
			background-color: #efeff4;
		}
		.mui-bar~.mui-content .mui-fullscreen {
			top: 44px;
			height: auto;
		}
		.mui-pull-top-tips {
			position: absolute;
			top: -20px;
			left: 50%;
			margin-left: -25px;
			width: 40px;
			height: 40px;
			border-radius: 100%;
			z-index: 1;
		}
		.mui-bar~.mui-pull-top-tips {
			top: 24px;
		}
		.mui-pull-top-wrapper {
			width: 42px;
			height: 42px;
			display: block;
			text-align: center;
			background-color: #efeff4;
			border: 1px solid #ddd;
			border-radius: 25px;
			background-clip: padding-box;
			box-shadow: 0 4px 10px #bbb;
			overflow: hidden;
		}
		.mui-pull-top-tips.mui-transitioning {
			-webkit-transition-duration: 200ms;
			transition-duration: 200ms;
		}
		.mui-pull-top-tips .mui-pull-loading {
			/*-webkit-backface-visibility: hidden;
            -webkit-transition-duration: 400ms;
            transition-duration: 400ms;*/

			margin: 0;
		}
		.mui-pull-top-wrapper .mui-icon,
		.mui-pull-top-wrapper .mui-spinner {
			margin-top: 7px;
		}
		.mui-pull-top-wrapper .mui-icon.mui-reverse {
			/*-webkit-transform: rotate(180deg) translateZ(0);*/
		}
		.mui-pull-bottom-tips {
			text-align: center;
			background-color: #efeff4;
			font-size: 15px;
			line-height: 40px;
			color: #777;
		}
		.mui-pull-top-canvas {
			overflow: hidden;
			background-color: #fafafa;
			border-radius: 40px;
			box-shadow: 0 4px 10px #bbb;
			width: 40px;
			height: 40px;
			margin: 0 auto;
		}
		.mui-pull-top-canvas canvas {
			width: 40px;
		}
		.mui-slider-indicator.mui-segmented-control,.mui-segmented-control.mui-scroll-wrapper .mui-scroll {
			background-color: #fff;height: 45px;
		}
		.mui-segmented-control .mui-control-item{line-height: 45px;}
		.mui-segmented-control.mui-scroll-wrapper .mui-control-item{width: 33.3%;}
		.mui-segmented-control.mui-scroll-wrapper .mui-scroll{width: 100%;}
	</style>

<body>
<header class="mui-bar mui-bar-nav  index-headers">
	<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left color" href='javascript:;' ></a>
	<h1 class="mui-title color">我的订单</h1>

</header>
<div class="mui-content user_dd">
	<div id="slider" class="mui-slider mui-fullscreen">
		<div id="sliderSegmentedControl" class="mui-scroll-wrapper mui-slider-indicator mui-segmented-control mui-segmented-control-inverted">
			<div class="mui-scroll">
				<?php if(is_array($headerList) || $headerList instanceof \think\Collection || $headerList instanceof \think\Paginator): if( count($headerList)==0 ) : echo "" ;else: foreach($headerList as $key=>$value): ?>
				<a class="mui-control-item <?php if($key == $state): ?> mui-active <?php endif; ?>" href="<?php echo url('',['state'=>0]); ?>">
					<?php echo $value; ?>
				</a>
				<?php endforeach; endif; else: echo "" ;endif; ?>

			</div>
		</div>
		<div class="mui-slider-group">
			<div id="item1mobile" class="mui-slider-item mui-control-content mui-active">
				<div id="scroll1" class="mui-scroll-wrapper">
					<div class="mui-scroll">
						<ul class="mui-table-view">
							<li class="mui-table-view-cell">
								<div>
									<h4>河南省焦作市修武县云台山风景区</h4>
									<p>订单编号：12314568876463133584</p>
									<p>订单金额：450元</p>
									<p>订单数：3人</p>
									<p>目的地：河南省焦作市修武县云台山风景区</p>
									<p>预约时间：2019-04-08 13:52</p>
									<p class="mui-blue">活动时间：2019-04-10-2019-04-11</p>
									<a href="" class="mui-pull-right">景区详情</a>
									<span>已预约</span>
								</div>
							</li>
							<li class="mui-table-view-cell">
								<div>
									<h4>河南省焦作市修武县云台山风景区</h4>
									<p>订单编号：12314568876463133584</p>
									<p>订单金额：450元</p>
									<p>订单数：3人</p>
									<p>目的地：河南省焦作市修武县云台山风景区</p>
									<p>预约时间：2019-04-08 13:52</p>
									<p class="mui-blue">活动时间：2019-04-10-2019-04-11</p>
									<a href="" class="mui-pull-right">景区详情</a>
									<span class="bg-red">已出行</span>
								</div>
							</li>

						</ul>
					</div>
				</div>
			</div>
			<div id="item2mobile" class="mui-slider-item mui-control-content">
				<div class="mui-scroll-wrapper">
					<div class="mui-scroll">
						<ul class="mui-table-view">

						</ul>
					</div>
				</div>
			</div>
			<div id="item3mobile" class="mui-slider-item mui-control-content">
				<div class="mui-scroll-wrapper">
					<div class="mui-scroll">
						<ul class="mui-table-view">
							<li class="zanwu mui-text-center" style="background: #efefef;">
								<img src="/static/h5/images/wode/zanwu.png" alt="" width="40">
							</li>
						</ul>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<script src="/static/h5/js/mui.min.js"></script>
<script src="/static/h5/js/mui.pullToRefresh.js"></script>
<script src="/static/h5/js/mui.pullToRefresh.material.js"></script>
<script>
	mui.init();
	(function($) {
		//阻尼系数
		var deceleration = mui.os.ios?0.003:0.0009;
		$('.mui-scroll-wrapper').scroll({
			bounce: false,
			indicators: true, //是否显示滚动条
			deceleration:deceleration
		});
		$.ready(function() {
			//循环初始化所有下拉刷新，上拉加载。
			$.each(document.querySelectorAll('.mui-slider-group .mui-scroll'), function(index, pullRefreshEl) {
				$(pullRefreshEl).pullToRefresh({
					down: {
						callback: function() {
							var self = this;
							setTimeout(function() {
								window.location.reload()

								self.endPullDownToRefresh();
							}, 1000);
						}
					},
					up: {
						callback: function() {
							var self = this;
							setTimeout(function() {
								var ul = self.element.querySelector('.mui-table-view');
								ul.appendChild(createFragment(ul, index, 5));
								self.endPullUpToRefresh();
							}, 1000);
						}
					}
				});
			});
			var createFragment = function(ul, index, count, reverse) {
			    $.ajax({
					url:'',
					data:'',
					dataType:'json',
					type:'get',
					success:function (res) {
						console.log(res)
                    }
				})
				var length = ul.querySelectorAll('li').length;
				var fragment = document.createDocumentFragment();
				var li;
				for (var i = 0; i < count; i++) {
					li = document.createElement('li');
					li.className = 'mui-table-view-cell';
					li.innerHTML = ('<div>'+
							'<h4>河南省焦作市修武县云台山风景区</h4>'+
							'<p>订单编号：12314568876463133584</p>'+
							'<p>订单金额：450元</p>'+
							'<p>订单数：3人</p>'+
							'<p>目的地：河南省焦作市修武县云台山风景区</p>'+
							'<p>预约时间：2019-04-08 13:52</p>'+
							'<p class="mui-blue">活动时间：2019-04-10-2019-04-11</p>'+
							'<a href="" class="mui-pull-right">景区详情</a>'+
							'<span>已预约</span>'+
							'</div>')
					//li.innerHTML = '第' + (index + 1) + '个选项卡子项-' + (length + (reverse ? (count - i) : (i + 1)));
					fragment.appendChild(li);
				}
				return fragment;
			};
		});
	})(mui);
</script>
</body>

</html>