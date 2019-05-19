<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"/www/wwwroot/lv.wyc168.com/public/../application/h5/view/vipcard/card_buy.html";i:1557998956;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <title>会员卡订单</title>

    <link href="/static/h5/css/mui.min.css" rel="stylesheet">
    <link href="/static/h5/css/mui.poppicker.css" rel="stylesheet">
    <link href="/static/h5/css/mui.picker.css" rel="stylesheet">
    <link href="/static/h5/css/swiper-3.4.2.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/static/h5/fonts/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/static/h5/css/swiper-3.4.2.min.css"/>
    <link rel="stylesheet" href="/static/h5/css/index.css">
    <style type="text/css">
        .mui-table-view,.mui-input-group{background: transparent;}

    </style>
</head>
<body>
<header class="mui-bar mui-bar-nav  index-headers">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left color" href='javascript:;' ></a>
    <h1 class="mui-title color">会员卡订单</h1>

</header>
<div class="mui-content mui-scroll-wrapper mui-button" id="pullrefresh">
    <div class="mui-scroll">

        <div class="mui-table-view mui-table-view-chevron  card_dd " >
            <form class="mui-input-group">
                <div class="mui-ddan">
                    <div class="dd_title"><img src="images/dingdan.png" width="20" alt="" style="vertical-align: middle;margin-right: 5px;"></i>订单详情</div>
                    <div class="dd_center">
                        <p class="price">卡片类型：<span class='mui-red mui-pull-right'><?php echo $cardInfo->title; ?></span></p>
                        <p class="price">订单总价：<span class='mui-red mui-pull-right'>￥<?php echo $cardInfo->price; ?></span></p>
                        <p class="dd_num">
                            购买数量：
                            <span class=' mui-pull-right'>
										<button type="button" class="mui-btn del">-</button><input type="text" name="num" id="num" value="1" readonly /><button type="button" class="mui-btn add">+</button>
									</span>
                        </p>
                        <input type="hidden" value="<?php echo $cardInfo->card_id; ?>" name="id">
                    </div>
                </div>
                <div class="mui-ddan" style="margin-top: 10px;">

                    <div class="dd_center">
                        <p class="price">支付方式：<input id="showUserPicker" name="zhifu" value="支付方式" class='mui-blue mui-pull-right' style="color: #2992ff;text-align: right;width: 80px;"></p>

                    </div>
                </div>
                <button type="button" class="mui-btns" >立即购买</button>

            </form>
        </div>

    </div>
</div>

<script src="/static/h5/js/jquery-1.11.0.min.js"></script>
<script src="/static/h5/js/mui.js"></script>
<script src="/static/h5/js/mui.picker.js"></script>
<script src="/static/h5/js/mui.poppicker.js"></script>
<script src="/static/h5/js/index.js" type="text/javascript" charset="utf-8"></script>
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
    $('.del')[0].addEventListener('tap',function(){
        var num=$('#num').val()
        if(num=='1'){mui.toast('数量不能小于1');return false}
        num=parseFloat(num)-1;
        $('#num').val(num)

    })
    $('.add')[0].addEventListener('tap',function(){
        var num=$('#num').val()
        num=parseFloat(num)+1;
        $('#num').val(num)

    })
    var userPicker = new mui.PopPicker();
    userPicker.setData([{
        value: '0',
        text: '支付宝'
    }, {
        value: '1',
        text: '微信'
    }, {
        value: '2',
        text: '银行卡'
    }]);
    var showUserPickerButton = document.getElementById('showUserPicker');

    showUserPickerButton.addEventListener('tap', function(event) {
        userPicker.show(function(items) {
            $(showUserPickerButton).val(items[0].text)
            //返回 false 可以阻止选择框的关闭
            //return false;
        });
    }, false);
    $('button.mui-btns')[0].addEventListener('tap',function(){
        var data=$('form').serialize()
        $.ajax({
            url:"<?php echo url('vipcard/doCardBuy'); ?>",
            type:'post',
            dataType:'json',
            data:data,
            success:function (res) {
                if (res.code == 1){
                    mui.toast(res.msg)
                }
                mui.toast(res.msg)
            }
        })
    })
</script>

</body>
</html>
