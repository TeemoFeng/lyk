<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:80:"/www/wwwroot/lv.wyc168.com/public/../application/h5/view/user/user_integral.html";i:1558080408;s:65:"/www/wwwroot/lv.wyc168.com/application/h5/view/public/header.html";i:1557896288;s:65:"/www/wwwroot/lv.wyc168.com/application/h5/view/public/footer.html";i:1557906906;}*/ ?>
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
		<title>我的积分</title>
	<body>
		<header class="mui-bar mui-bar-nav  index-headers">
			<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left color" href='javascript:;' ></a>
			<h1 class="mui-title color">我的积分</h1>
			
		</header>
		<div class="mui-content mui-scroll-wrapper" id="pullrefresh">
			<div class="mui-scroll">
				
				<div class="mui-table-view mui-table-view-chevron    " >
					<div class="team_header">
						<div class="flex">
							
							<div class="flex-item mui-text-center">
								<p class="mui-bai">总提现积分</p>
								<p class="mui-bai font15" style="font-size: 20px;">15313</p>
							</div>
						</div>
					</div>
					<div class="mui-table" style="padding: 0 ;">
						<table border="" >
							<tr>
								<th>提现日期</th>
								<th>提现积分</th>
								<th>状态</th>
							</tr>
							<tr>
								<td class="mui-ellipsis">2019-10-05 20:05:02</td>
								<td class="mui-ellipsis">654646</td>
								<td class="mui-ellipsis">提现成功</td>
							</tr>
							<tr>
								<td class="mui-ellipsis">2019-10-05 20:05:02</td>
								<td class="mui-ellipsis">35</td>
								<td class="mui-ellipsis">提现成功</td>
							</tr>
							<tr>
								<td class="mui-ellipsis">2019-10-05 20:05:02</td>
								<td class="mui-ellipsis">6654</td>
								<td class="mui-ellipsis">提现成功</td>
							</tr>
						</table>
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

        function a() {
            $.ajax({
                url:"<?php echo url('user/ajaxUserIntegral'); ?>",
                data:'page='+1,
                type:'get',
                dataType:'json',
                success:function (res) {
                    console.log(res)
                }
            })
        }
        a()
		
			
		</script>
		
	</body>
</html>
