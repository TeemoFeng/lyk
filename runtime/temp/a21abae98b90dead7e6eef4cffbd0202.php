<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:59:"D:\lyk\public/../application/h5\view\vipcard\card_list.html";i:1557929176;s:45:"D:\lyk\application\h5\view\public\header.html";i:1557896290;s:42:"D:\lyk\application\h5\view\public\nav.html";i:1557969050;s:45:"D:\lyk\application\h5\view\public\footer.html";i:1557906908;}*/ ?>
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
<header class="mui-bar mui-bar-nav  index-headers">

    <h1 class="mui-title color">会员</h1>

</header>
<div class="mui-content mui-scroll-wrapper mui-bottom" id="pullrefresh">
    <div class="mui-scroll">

        <div class="swiper-container gallery-top">
            <div class="swiper-wrapper">
                <?php if(is_array($cards) || $cards instanceof \think\Collection || $cards instanceof \think\Paginator): $i = 0; $__LIST__ = $cards;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$co): $mod = ($i % 2 );++$i;?>
                <div class="swiper-slide"><img src="<?php echo $co->w_image_path; ?>" alt=""></div>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
        <div class="swiper-container gallery-thumbs swiper-no-swiping">
            <div class="swiper-wrapper">
                <?php if(is_array($cards) || $cards instanceof \think\Collection || $cards instanceof \think\Paginator): $i = 0; $__LIST__ = $cards;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$co): $mod = ($i % 2 );++$i;?>
                <div class="swiper-slide">
                    <div class="flex">
                        <img src="/static/h5/images/huiyuan/huangguan.png" alt="">
                        <div class="card_jieshao">
                            <h5>卡种介绍</h5>
                            <div><?php echo $co->introduce; ?></div>
                        </div>
                    </div>
                    <div class="flex">
                        <img src="/static/h5/images/huiyuan/xunzhang.png" alt="">
                        <div class="card_jieshao">
                            <h5>卡中介绍</h5>
                            <div><?php echo $co->introduce; ?></div>
                        </div>
                    </div>
                    <a href="<?php echo url('vipcard/cardbuy',['id'=>$co->card_id]); ?>" class="mui-btns">点击进入</a>
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

    var galleryThumbs = new Swiper('.gallery-thumbs', {
        spaceBetween: 10,
        slidesPerView: 1,
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
    });
    var galleryTop = new Swiper('.gallery-top', {


    });
    galleryTop.params.control = galleryThumbs;

</script>

</body>
</html>
