<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:83:"/www/wwwroot/lv.wyc168.com/public/../application/h5/view/vipcard/card_make_out.html";i:1557998242;}*/ ?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <title>卡片互转</title>

    <link href="/static/h5/css/mui.min.css" rel="stylesheet">
    <link href="/static/h5/css/swiper-3.4.2.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/static/h5/fonts/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/static/h5/css/swiper-3.4.2.min.css"/>
    <link href="/static/h5/css/mui.picker.css" rel="stylesheet" />
    <link href="/static/h5/css/mui.poppicker.css" rel="stylesheet" />
    <link rel="stylesheet" href="/static/h5/css/index.css">
</head>

<body>
<header class="mui-bar mui-bar-nav  index-headers">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left color" href='javascript:;'></a>
    <h1 class="mui-title color">卡片互转</h1>

</header>
<div class="mui-content mui-scroll-wrapper " id="pullrefresh" style="background: #fff;">
    <div class="mui-scroll">
        <div class="mui-table-view mui-table-view-chevron mui-bottom">
            <div class="mui-dizhi-add ">

                <form class="">
                    <div class="mui-input-row">
                        <label>卡类选择</label>

                    </div>
                    <div class="mui-input-row flex">
                        <?php if(is_array($cards) || $cards instanceof \think\Collection || $cards instanceof \think\Paginator): $i = 0; $__LIST__ = $cards;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$co): $mod = ($i % 2 );++$i;?>
                        <div class=" mui-radio mui-left">
                            <label style="width: 100px;padding-left: 26px;"><?php echo $co->title; ?></label>
                            <input name="card_id" onclick="getMemberCard(<?php echo $co->card_id; ?>)" type="radio" value="<?php echo $co->card_id; ?>"  style='border: none;padding-left: 0;vertical-align: middle;margin-top: -4px;'>
                        </div>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                    <div class="mui-input-row">
                        <label>卡编号</label>
                        <select name="id" class="card_zhaun_s">
                            <option value="3">请选择需要转出的卡</option>
                        </select>
                    </div>
                    <div class="mui-input-row">
                        <label>转入账号</label>
                        <input type="tel" name="put_mobile"  placeholder="请输入转入方手机号">
                    </div>

                    <button id="submite" type="button" class="btns"> 确认</button>
                </form>


            </div>


        </div>
    </div>
</div>

<script src="/static/h5/js/jquery-1.11.0.min.js"></script>

<script src="/static/h5/js/mui.js"></script>
<script src="/static/h5/js/mui.picker.js"></script>
<script src="/static/h5/js/mui.poppicker.js"></script>
<script src="/static/h5/js/city.data.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/h5/js/city.data-3.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/h5/js/index.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/h5/js/ajax_Submit.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/h5/js/swiper-3.4.1.min.js" type="text/javascript" charset="utf-8"></script>
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

    function getMemberCard(cardId){
        $.ajax({
            url:"<?php echo url('vipcard/getMemberAllCard'); ?>",
            type:'get',
            dataType:'json',
            data:'cardId='+cardId,
            success:function (res) {
                console.log(res)
            }
        })
    }

    $('#submite')[0].addEventListener('tap',function(){
        var data=$('form').serialize()
        ajax_Submit("",data,'post')

    })
</script>

</body>

</html>