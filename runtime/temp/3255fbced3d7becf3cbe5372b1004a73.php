<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"/www/wwwroot/lv.wyc168.com/public/../application/h5/view/user/user_card.html";i:1558079866;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
	<title>我的卡包</title>
	<link href="/static/h5/css/mui.min.css" rel="stylesheet">
	<link href="/static/h5/css/swiper-3.4.2.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/static/h5/css/animate.min.css" />
	<link rel="stylesheet" type="text/css" href="/static/h5/fonts/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="/static/h5/css/swiper-3.4.2.min.css" />
	<link rel="stylesheet" href="/static/h5/css/index.css">
	<style type="text/css">
		.mui-content {
			background: #fff;
		}
	</style>


</head>
<body>
<header class="mui-bar mui-bar-nav  index-headers">
	<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left color" href='javascript:;' ></a>
	<h1 class="mui-title color">我的卡包</h1>

</header>
<div class="mui-content mui-scroll-wrapper" id="pullrefresh">
	<div class="mui-scroll" >

		<div class="mui-table-view mui-table-view-chevron user-card " >

			<div id="segmentedControl" class="mui-segmented-control ">
				<?php if(is_array($header) || $header instanceof \think\Collection || $header instanceof \think\Paginator): $i = 0; $__LIST__ = $header;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ho): $mod = ($i % 2 );++$i;?>
				<a class="mui-control-item <?php if($ho->card_id == $cardId): ?> mui-active <?php endif; ?>" href="<?php echo url('',['cardId'=>$ho->card_id]); ?>">
					<?php echo $ho->title; ?>
				</a>
				<?php endforeach; endif; else: echo "" ;endif; ?>
				<!--<a class="mui-control-item" href="#item2">-->
					<!--至尊卡-->
				<!--</a>-->

			</div>
			<div>
				<div id="item1" class="mui-control-content mui-active">

					<ul class="mui-list-unstyled mui-clearfix">
						<li class="box">
							<div class="zheng active">
								<img src="/static/h5/images/wode/jingpinka.png" alt="">
								<div class="wenben">卡片编码:6546546565</div>
							</div>
							<div class="fan">
								<img src="/static/h5/images/wode/jingpinkaxuanzhuan.png" alt="">
								<div class="xuzhi">
									<div style="color: #333;">密码 : 123456</div>
									<div class='top'>会员须知</div>
									<div class='font'>1、本卡出售后不可退换，消费不记名，可转让、赠与但不可兑换现金、物品。</div>
									<div class='font'>2、出团前每人缴纳500元保证金（避免临时有事取消行程），参团当天立刻退还。</div>
									<div class='font'>3、获取此卡后需预约出行日期，具体请致电咨询客服细则详见此卡所附属资料。</div>
									<div class='font'>4、此卡属于目的旅游，不包含往返大交通。结合自由行，自驾游，团体游均可。</div>
									<div class='top' style="width: 410px;">本卡最终解释权归发布卡方所有购买此卡即视为接受本卡使用规则客服</div>
									<div>电话：400-005-5212</div>
								</div>

							</div>
						</li>
						<li class="box">
							<div class="zheng active">
								<img src="/static/h5/images/wode/jingpinka.png" alt="">
								<div class="wenben">卡片编码:6546546565</div>
							</div>
							<div class="fan">
								<img src="/static/h5/images/wode/jingpinkaxuanzhuan.png" alt="">
								<div class="xuzhi">
									<div style="color: #333;">密码 : 123456</div>
									<div class='top'>会员须知</div>
									<div class='font'>1、本卡出售后不可退换，消费不记名，可转让、赠与但不可兑换现金、物品。</div>
									<div class='font'>2、出团前每人缴纳500元保证金（避免临时有事取消行程），参团当天立刻退还。</div>
									<div class='font'>3、获取此卡后需预约出行日期，具体请致电咨询客服细则详见此卡所附属资料。</div>
									<div class='font'>4、此卡属于目的旅游，不包含往返大交通。结合自由行，自驾游，团体游均可。</div>
									<div class='top' style="width: 410px;">本卡最终解释权归发布卡方所有购买此卡即视为接受本卡使用规则客服</div>
									<div>电话：400-005-5212</div>
								</div>
							</div>
						</li>
					</ul>
				</div>
				<div id="item2" class="mui-control-content">
					<ul class="mui-list-unstyled mui-clearfix">
						<li class="box">
							<div class="zheng active"><img src="images/wode/zhizunka.png" alt=""></div>
							<div class="fan"><img src="images/wode/zhizunkaxuanzhuan.png" alt=""></div>
						</li>
						<li class="box">
							<div class="zheng active"><img src="images/wode/zhizunka.png" alt=""></div>
							<div class="fan"><img src="images/wode/zhizunkaxuanzhuan.png" alt=""></div>
						</li>
					</ul>
				</div>
				<input type="hidden" value="<?php echo $cardId; ?>" id="cardId">
			</div>

		</div>

	</div>
</div>

<script src="/static/h5/js/jquery-1.11.0.min.js"></script>
<script src="/static/h5/js/mui.js"></script>

<script src="/static/h5/js/index.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/h5/js/swiper-3.4.1.min.js" type="text/javascript" charset="utf-8"></script>
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
    var zheng=$('.box .zheng')
    for(var i=0;i<zheng.length;i++){
        zheng[i].addEventListener('tap',function(){
            $(this).addClass('test ')
            var sss=$(this)
            setTimeout(function() {

                sss.removeClass('active')
                sss.next().addClass('active ')
                sss.removeClass('test ')
            }, 500);
        })
    }

    var  cardId = $('#cardId').val()

    function a() {
		$.ajax({
			url:"",
			data:'cardId='+cardId,
			type:'get',
			dataType:'json',
			success:function (res) {
				console.log(res)
            }
		})
    }
    a()

    var fan=$('.box .fan')
    for(var i=0;i<zheng.length;i++){
        fan[i].addEventListener('tap',function(){
            $(this).addClass('test ')
            var sss=$(this)
            setTimeout(function() {

                sss.removeClass('active')
                sss.prev().addClass('active ')
                sss.removeClass('test ')
            }, 500);


        })
    }
</script>

</body>
</html>
