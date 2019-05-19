<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:73:"/www/wwwroot/lv.wyc168.com/public/../application/h5/view/index/index.html";i:1558090883;s:65:"/www/wwwroot/lv.wyc168.com/application/h5/view/public/header.html";i:1557896288;s:62:"/www/wwwroot/lv.wyc168.com/application/h5/view/public/nav.html";i:1557969048;s:65:"/www/wwwroot/lv.wyc168.com/application/h5/view/public/footer.html";i:1557906906;}*/ ?>
<!DOCTYPE html>
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
<body>
<div class="mui-content mui-scroll-wrapper" id="pullrefresh">
	<div class="mui-scroll">
		<header class="mui-bar  index-header" style="padding: 0 30px;">
			<div class="mui-input-row mui-search" id="searchForm">
				<input type="search" id="searchInput" onkeyup="enterSearch(event)" class="mui-input-clear" placeholder="搜你想要的东西">
			</div>

		</header>
		<div class="mui-table-view mui-table-view-chevron mui-index  mui-top mui-bottom" >
			<div class="bg"></div>
			<div class="swiper-container mui-index-swiper">
				<div class="swiper-wrapper">
					<?php if(is_array($banner) || $banner instanceof \think\Collection || $banner instanceof \think\Paginator): $i = 0; $__LIST__ = $banner;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$bo): $mod = ($i % 2 );++$i;?>
					<div class="swiper-slide"><a href="#"><img src="<?php echo $bo->w_image_path; ?>" ></a></div>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
			</div>
			<div class="index-gonggao">
				<i class="fa fa-volume-up"></i><span>客服热线:40000000000(08:00-24:00)</span>
			</div>
			<div class="bg1"></div>
			<div class="mui-zhuda-title bg-fff mui-text-center">
				<span class="xian"></span>
				<div class="main">
					<i class="i1"></i><i class="i2"></i><p>核心功能</p><i class="i2"></i><i class="i1"></i>
				</div>
			</div>
			<div class="index-main">
				<ul class="flex mui-list-unstyled">
					<li class="flex-item"><a href="<?php echo url('category/categoryTypeController',['cid'=>2,'displayType'=>1]); ?>"><img src="/static/h5/images/huodongjingqu.png" alt=""></a></li>
					<li class="flex-item"><a href="<?php echo url('category/categoryTypeController',['cid'=>0,'displayType'=>2]); ?>"><img src="/static/h5/images/remenluxian.png" alt=""></a></li>
					<li class="flex-item"><a href="<?php echo url('index/indexJihuo'); ?>"><img src="/static/h5/images/kapianjihuo.png" alt=""></a></li>
				</ul>
			</div>
			<div class="bg1"></div>
			<div class="mui-zhuda-title bg-fff mui-text-center">
				<span class="xian"></span>
				<div class="main">
					<i class="i1"></i><i class="i2"></i><p>每周特价推荐</p><i class="i2"></i><i class="i1"></i>
				</div>
			</div>
			<div class="index-jq">
				<div class="index-jq-list">
					<a href="<?php echo url('trip/tjdetail',['sid'=>1]); ?>" class="flex">
						<img src="/static/h5/images/tu2.jpg" alt="">
						<div>
							<h5>新马泰五天六夜豪华游</h5>
							<p  class="mui-ellipsis">时间:2019/03/15</p>
							<p  class="mui-ellipsis">安排:新加坡-马来西亚-泰国曼谷</p>
							<p  class="mui-ellipsis">热度: <i class=" fa fa-heart"></i><i class=" fa fa-heart"></i><i class=" fa fa-heart"></i></p>
						</div>
					</a>
				</div>
				<div class="index-jq-list">
					<a href="jingqu_shop.html" class="flex">
						<img src="/static/h5/images/tu2.jpg" alt="">
						<div>
							<h5>新马泰五天六夜豪华游</h5>
							<p  class="mui-ellipsis">时间:2019/03/15</p>
							<p  class="mui-ellipsis">安排:新加坡-马来西亚-泰国曼谷</p>
							<p  class="mui-ellipsis">热度: <i class=" fa fa-heart"></i><i class=" fa fa-heart"></i><i class=" fa fa-heart"></i><i class=" fa fa-heart"></i><i class=" fa fa-heart"></i></p>
						</div>
					</a>
				</div>
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
    function enterSearch(event){
        if(event.keyCode == 13) {//用户点击回车的事件号为13
            var keyword = document.getElementById('searchInput').value;
            alert(keyword);
        }
    }

</script>
<script>

    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        autoplay:5000,
        paginationClickable: true,

    });

	a()

    function a() {
		$.ajax({
			url:"",
			data:'',
			dataType:'json',
			type:'get',
			success:function(res){
			    console.log(res)
			}
		})
    }

</script>
</body>
</html>
