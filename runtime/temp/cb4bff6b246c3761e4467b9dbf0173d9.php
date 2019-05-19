<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:56:"D:\lyk\public/../application/h5\view\user\info_bind.html";i:1558196708;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <title>激活会员卡</title>


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
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left color" href='javascript:;' ></a>
    <h1 class="mui-title color">卡片激活</h1>

</header>
<div class="mui-content mui-scroll-wrapper" id="pullrefresh">
    <div class="mui-scroll">

        <div class="mui-table-view mui-table-view-chevron  jihuo_card " >
            <form class="mui-input-group">
                <div class="mui-input-row">
                    <label>激活信息</label>

                </div>

                <div class="mui-input-row">
                    <label>姓名</label>
                    <input type="text" class="mui-input-clear" name="name" placeholder="请输入姓名">
                </div>
                <div class="mui-input-row">
                    <label>身份证号</label>
                    <input type="text" class="mui-input-clear" name="name_id" placeholder="请输入身份证号">
                </div>
                <div class="mui-input-row">
                    <label>手机号</label>
                    <input type="tel" class="mui-input-clear" name="mobile" placeholder="请输入手机号">
                </div>
                <div class="mui-input-row">
                    <label>省/市/区</label>
                    <input type="text" name="addr" id='showCityPicker3' readonly  placeholder="请选择省市区">
                </div>
                <div class="mui-input-row">
                    <label>详细地址</label>
                    <textarea name="xiangxi"   placeholder="请选择详细地址"></textarea>
                </div>
                <button type="button" class="mui-btns" >立即绑定</button>

            </form>
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
    var cityPicker3 = new mui.PopPicker({
        layer: 3
    });
    cityPicker3.setData(cityData3);
    var showCityPickerButton = document.getElementById('showCityPicker3');

    showCityPickerButton.addEventListener('tap', function(event) {
        cityPicker3.show(function(items) {
            console.log(items[0].text)
            $(showCityPickerButton).val(items[0].text + items[1].text + items[2].text)
            //返回 false 可以阻止选择框的关闭
            //return false;
        });
    }, false);

    $('button.mui-btns')[0].addEventListener('tap',function(){
        var data=$('form').serialize()
        ajax_Submit("",data,'post')

    })
</script>

</body>
</html>
