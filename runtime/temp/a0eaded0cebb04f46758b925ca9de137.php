<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:63:"D:\lyk\public/../application/h5\view\category\through_list.html";i:1557900486;s:45:"D:\lyk\application\h5\view\public\header.html";i:1557896290;s:45:"D:\lyk\application\h5\view\public\footer.html";i:1557906908;}*/ ?>
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
<header class="mui-bar mui-bar-nav  index-headers">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left color" href='javascript:;' ></a>
    <h1 class="mui-title color">直通车</h1>

</header>
<div class="mui-content mui-scroll-wrapper" id="pullrefresh">
    <div class="mui-scroll">

        <div class="mui-table-view mui-table-view-chevron    " >

            <ul class="mui-list-unstyled mui-clearfix yufen">
                <?php if(is_array($month) || $month instanceof \think\Collection || $month instanceof \think\Paginator): $i = 0; $__LIST__ = $month;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mo): $mod = ($i % 2 );++$i;?>
                <li><a <?php if($i == $thisMonth): ?> class="active" <?php endif; ?> href="<?php echo url('',['cid'=>$cid,'displayType'=>1,'thisMonth'=>$i]); ?>"><?php echo $mo; ?></a></li>
                <?php endforeach; endif; else: echo "" ;endif; ?>

            </ul>

            <div class="active_list">
                <?php if(is_array($journeys) || $journeys instanceof \think\Collection || $journeys instanceof \think\Paginator): $i = 0; $__LIST__ = $journeys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$jo1): $mod = ($i % 2 );++$i;?>
                <div class="active_title"><?php echo $jo1->title; ?></div>
                <ul class="mui-list-unstyled mui-clearfix">
                    <?php if(is_array($jo1->son) || $jo1->son instanceof \think\Collection || $jo1->son instanceof \think\Paginator): $i = 0; $__LIST__ = $jo1->son;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$jo2): $mod = ($i % 2 );++$i;?>
                    <li>
                        <a href="<?php echo url('trip/detail',['jid'=>$jo2->id]); ?>">
                            <img src="<?php echo $jo2->csInfo->w_image_path; ?>" alt="">
                            <p class="font15  mui-ellipsis"><?php echo $jo2->csInfo->title; ?></p>
                            <p class="font12  mui-ellipsis"><?php echo $jo2->csInfo->intro; ?></p>
                            <p class="font12 mui-ellipsis">预约开始时间：<?php echo $jo2->s_time; ?></p>
                            <p class="font12 mui-ellipsis">预约结束时间：<?php echo $jo2->e_time; ?></p>
                            <?php if($jo2->vehicle): ?>
                            <span class="mui-bg-blue">直通车</span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
                <?php endforeach; endif; else: echo "" ;endif; ?>
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
