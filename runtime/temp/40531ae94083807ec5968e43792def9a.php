<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:61:"D:\lyk\public/../application/h5\view\vipcard\card_active.html";i:1558202943;}*/ ?>
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

				<div class="mui-input-row flex">
					<?php if(is_array($cards) || $cards instanceof \think\Collection || $cards instanceof \think\Paginator): $i = 0; $__LIST__ = $cards;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$co): $mod = ($i % 2 );++$i;?>
					<div class=" mui-radio mui-left">
						<label><?php echo $co->title; ?></label>
						<input name="card_id" type="radio" value="<?php echo $co->card_id; ?>" typ="<?php echo $co->card_type; ?>" >
					</div>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
				<div class="mui-input-row">
					<label>卡号</label>
					<input type="text" class="mui-input-clear" name="card_number" placeholder="请输入卡号">
				</div>
				<div class="mui-input-row active">
					<label>卡密</label>
					<input type="password" class="mui-input-password" name="password" placeholder="请输入卡密">
				</div>
				<?php if($uInfo->parent_id == 0): ?>
				<div class="mui-input-row  tuijianr active">
					<label>推荐人手机</label>
					<input type="text" name="pmobile" class="mui-input-clear" placeholder="请输入推荐人手机">
				</div>
				<?php endif; ?>
				<input type="hidden"  value="<?php echo $bind; ?>">
				<button type="button" class="mui-btns" >立即激活</button>

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


    var radios=$(".mui-radio")
    for(var i=0;i<radios.length;i++){
        radios[i].addEventListener('tap',function(){
            if($(this).children('input').attr('typ')==1){
                $('.tuijianr').addClass('active')
            }else{
                $('.tuijianr').removeClass('active')
            }
        })
    }
    $('button.mui-btns')[0].addEventListener('tap',function(){
        var data=$('form').serialize()
		ajax_Submit("",data,'post')

        //if(data[6].value==''||data[8].value==null){mui.toast('推荐人不能为空'); return false}

    })
</script>

</body>
</html>
