<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:59:"D:\lyk\public/../application/wycadmin\view\login\index.html";i:1557882664;s:51:"D:\lyk\application\wycadmin\view\public\footer.html";i:1555746880;}*/ ?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Login</title>

    <link href="/static/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/admin/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/static/admin/css/animate.css" rel="stylesheet">
    <link href="/static/admin/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">IN+</h1>

        </div>
        <h3>Welcome to IN+</h3>


        <form class="m-t" role="form" action="" id="login">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="账号" required="" name="username">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="密码" required="" name="password">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" style='width:58%;display:inline-block' placeholder="验证码" required="" name="captcha" />
                <button type="button" onclick="getCode()">获取验证码</button>
                <!--<img src="/captcha" alt="点击刷新验证码" onclick="coodeRefresh(this)" id="captcha" style='width:40%;height:38px'/>-->
            </div>
            <button type="button" onclick="loginSubmit()" class="btn btn-primary block full-width m-b">登录</button>
            <!--<a href="login.html#"><small>Forgot password?</small></a>-->

        </form>

    </div>
</div>

<!-- Mainly scripts -->
<!-- Mainly scripts -->
<script src="/static/admin/js/jquery-3.1.1.min.js"></script>
<script src="/static/admin/js/bootstrap.min.js"></script>
<script src="/static/admin/js/jquery.metisMenu.js"></script>
<script src="/static/admin/js/jquery.slimscroll.min.js"></script>
<script src="/static/admin/js/counterup.min.js"></script>
<script src="/static/admin/js/waypoints.min.js"></script>
<script src="/static/admin/js/ajaxSubmit.js"></script>
<!-- Custom and plugin javascript -->
<script src="/static/admin/js/layer/layer_3.0/layer.js"></script>
<script src="/static/admin/js/inspinia.js"></script>
<script src="/static/admin/js/pace.min.js"></script>
<script src="/static/admin/js/index.js" type="text/javascript" charset="utf-8"></script>
<script  type="text/javascript" charset="utf-8">
  var lists=$('.nav-second-level')
			for(var i=0;i<lists.length;i++){
				$(lists[i]).prev().children('.xiaobiao').html($(lists[i]).children().length)
				
			}
</script>

</body>
<script>
    function coodeRefresh(obj) {
        obj.src = "/captcha?id="+Math.random();
    }
    function loginSubmit() {
        ajax_Submit("",$('#login').serialize(),'post')
        setTimeout(function () {
            coodeRefresh(document.getElementById('captcha'))
        },1200)

    }


    function getCode(){
        ajax_Submit()
        $.ajax({
            url: "<?php echo url('api/code/getSms'); ?>",
            data: {'mobile': 12345678911, 'type': 'admin'},
            type: 'post',
            dataType: 'json',
            success: function (res) {
                layer.msg(res.msg, {icon: 1});
                if (res.msg == '短信发送成功') {
                    showtime(60)
                }
            }
        })
    }

    //显示时间
    function showtime(t){
        $("#send_code").attr('disabled',true);
        for(i=1;i<=t;i++){
            window.setTimeout(updatetime, i * 1000,i,t);
        }
    }
    //更新时间
    var updatetime = function(num,t) {
        if (num == t) {
            $("#send_code").attr('disabled', false);
            $("#send_code").text("重新发送");
        } else {
            remaintime = t - num;
            $("#send_code").text(remaintime+'S');
        }
    }
</script>
</html>
