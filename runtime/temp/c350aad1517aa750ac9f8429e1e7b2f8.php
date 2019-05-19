<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:53:"D:\lyk\public/../application/h5\view\trip\detail.html";i:1557992690;s:45:"D:\lyk\application\h5\view\public\header.html";i:1557896290;s:45:"D:\lyk\application\h5\view\public\footer.html";i:1557906908;}*/ ?>
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
			.mui-content {
				background: #fff;
			}
		</style>
	<body>
		<header class="mui-bar mui-bar-nav  index-headers">
			<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left color" href='javascript:;'></a>
			<h1 class="mui-title color">景区详情</h1>

		</header>
		<div class="mui-content mui-scroll-wrapper" id="pullrefresh">
			<div class="mui-scroll">

				<div class="mui-table-view mui-table-view-chevron  jingqu_shop  " style="background: #eff3f6;">
					<?php if(is_array($banner) || $banner instanceof \think\Collection || $banner instanceof \think\Paginator): $i = 0; $__LIST__ = $banner;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$bo): $mod = ($i % 2 );++$i;?>
					<img src="<?php echo $bo->image; ?>" alt="">
					<?php endforeach; endif; else: echo "" ;endif; ?>
					<div class="jingqu_center">
						<h3 class="mui-ellipsis"><?php echo $info->title; ?>
							<span class="mui-pull-right">
								<?php $__FOR_START_7395__=0;$__FOR_END_7395__=$info->star;for($i=$__FOR_START_7395__;$i < $__FOR_END_7395__;$i+=1){ ?>
								<i class="fa fa-star"></i>
								<?php } ?>
							</span>
						</h3>
						<div class="flex mui-text-center">
							<div class="flex-item">
								<p class="mui-ellipsis"><?php echo $journey->w_vid; ?></p>
							</div>
							<div class="flex-item mui-ellipsis"><?php echo $info->star; ?>A级风景区</div>

						</div>
						<div class="mui-ellipsis"><i class="fa  fa-map-marker"></i><?php echo $info->addr; ?></div>
						<div class="mui-ellipsis"><i class="fa fa-calendar"></i><?php echo $journey->s_time; ?>-<?php echo $journey->e_time; ?></div>
						<div class="mui-ellipsis"><i class="fa fa-phone"></i><?php echo $journey->mobile; ?></div>
						<div class="mui-ellipsis"><i class="fa fa-user"></i><?php echo $journey->this_people_count; ?>/<?php echo $journey->max_people_count; ?>人 <button type="button" onclick="yuyue(<?php echo $journey->id; ?>)"   id="yu_yue" class="mui-pull-right mui-btn">立即预约</button></div>
					</div>
					<div class="jingqu_bt">
						<div id="segmentedControl" class="mui-segmented-control">
							<a class="mui-control-item mui-active" href="#item1">
								景区介绍
							</a>
							<a class="mui-control-item" href="#item2">
								自驾路线
							</a>
							<a class="mui-control-item" href="#item3">
								兑换须知
							</a>
						</div>
						<div>
							<div id="item1" class="mui-control-content mui-active">
								<div class="jingqu_main">
									<?php echo $info->introduce; ?>
								</div>
							</div>
							<div id="item2" class="mui-control-content">
								<div class="jingqu_main">
									<?php echo $info->circuit; ?>
								</div>
							</div>
							<div id="item3" class="mui-control-content">
								<div class="jingqu_main">
									<?php echo $info->notice; ?>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
		<script src="/static/h5/js/jquery-1.11.0.min.js"></script>
<script src="/static/h5/js/mui.js"></script>
<script src="/static/h5/js/index.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/h5/js/swiper-3.4.1.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/h5/js/ajax_Submit.js" type="text/javascript" charset="utf-8"></script>
		<script src="/static/h5/js/mui.zoom.js"></script>
		<script src="/static/h5/js/mui.previewimage.js"></script>
		<script type="text/javascript" charset="utf-8">
			mui.init({
				swipeBack: false,
				pullRefresh: {
					container: '#pullrefresh',
					down: {
						style: 'circle',
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
		<script>
			//window.open("dingdan_xq.html");
			mui.previewImage();
			(function(){
				var imgs=$('.jingqu_main img')
				for(var i=0;i<imgs.length;i++){
					$(imgs[i]).attr('data-preview-src','')
					$(imgs[i]).attr('data-preview-group',i)
				}
			})()

			function yuyue(id) {
				ajax_Submit("<?php echo url('trip/tripOrder'); ?>",'jid='+id,'get')
            }
		</script>
	</body>
</html>
