<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:53:"D:\lyk\public/../application/h5\view\index\index.html";i:1558166354;s:45:"D:\lyk\application\h5\view\public\header.html";i:1558149238;s:42:"D:\lyk\application\h5\view\public\nav.html";i:1557969050;s:45:"D:\lyk\application\h5\view\public\footer.html";i:1557906908;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <title></title>

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
						<div class="swiper-slide"><a href="javascript:;"><img src="<?php echo $bo->w_image_path; ?>" ></a></div>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
			</div>
			<div class="index-gonggao">
				<i class="fa fa-volume-up"></i><span>客服热线:400-005-5212(08:00-18:00)</span>
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
				<?php if(is_array($SpecialList) || $SpecialList instanceof \think\Collection || $SpecialList instanceof \think\Paginator): $i = 0; $__LIST__ = $SpecialList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				<div class="index-jq-list">
					<a href="<?php echo url('trip/tjdetail',['sid'=>$vo->id]); ?>" class="flex">
						<img src="<?php echo $vo->img; ?>" alt="">
						<div>
							<h5><?php echo $vo->title; ?></h5>
							<p  class="mui-ellipsis">时间:<?php echo $vo->s_time; ?></p>
							<p  class="mui-ellipsis">热度:
								<?php $__FOR_START_16240__=0;$__FOR_END_16240__=$vo->heat;for($i=$__FOR_START_16240__;$i < $__FOR_END_16240__;$i+=1){ ?>
								<i class=" fa fa-heart"></i>

								<?php } ?>
							</p>
						</div>
					</a>
				</div>
				<?php endforeach; endif; else: echo "" ;endif; ?>
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


</script>
</body>
</html>
