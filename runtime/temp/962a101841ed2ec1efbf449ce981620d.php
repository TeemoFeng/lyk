<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:87:"/www/wwwroot/lv.wyc168.com/public/../application/h5/view/category/destination_list.html";i:1557902134;s:65:"/www/wwwroot/lv.wyc168.com/application/h5/view/public/header.html";i:1557896288;s:65:"/www/wwwroot/lv.wyc168.com/application/h5/view/public/footer.html";i:1557906906;}*/ ?>
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
    <h1 class="mui-title color">热门景区</h1>

</header>
<div class="mui-content mui-scroll-wrapper" id="pullrefresh">
    <div class="mui-scroll">

        <div id="segmentedControl" class="mui-segmented-control ">
            <?php if(is_array($categorys) || $categorys instanceof \think\Collection || $categorys instanceof \think\Paginator): if( count($categorys)==0 ) : echo "" ;else: foreach($categorys as $k=>$co): ?>
            <a class="mui-control-item <?php if($cid == $k): ?> mui-active <?php endif; ?>" href="<?php echo url('category/categoryTypeController',['cid'=>$k,'displayType'=>2]); ?>">
                <?php echo $co; ?>
            </a>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <div class="re_list">
            <ul class="mui-list-unstyled mui-clearfix">
                <?php if(is_array($journeys) || $journeys instanceof \think\Collection || $journeys instanceof \think\Paginator): $i = 0; $__LIST__ = $journeys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$jo): $mod = ($i % 2 );++$i;?>
                <li>
                    <a href="<?php echo url('trip/detail',['jid'=>$jo->id]); ?>">
                        <img src="<?php echo $jo->csInfo->w_image_path; ?>" alt="">
                        <p class="font15  mui-ellipsis"><?php echo $jo->csInfo->title; ?></p>
                        <p class="mui-ellipsis"><?php echo $jo->csInfo->intro; ?></p>
                    </a>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
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
