<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:58:"D:\lyk\public/../application/h5\view\user\user_invite.html";i:1557973340;s:45:"D:\lyk\application\h5\view\public\header.html";i:1557896290;s:45:"D:\lyk\application\h5\view\public\footer.html";i:1557906908;}*/ ?>
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
	<title>我的推广</title>
	<body>
		<header class="mui-bar mui-bar-nav  index-header" style="background: transparent;">
			<a style="color: #333;" class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left " href='javascript:;' ></a>
			<h1 class="mui-title ">我的推广</h1>
			
		</header>
		<div class="mui-content mui-scroll-wrapper" id="pullrefresh" style="padding-top: 0;">
			<div class="mui-scroll">
				
				<div class="mui-table-view mui-table-view-chevron  index_jihuo " >
					<img src="<?php echo $code_path; ?>" alt="" class="index_jihuo">
					
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
		
	</body>
</html>
