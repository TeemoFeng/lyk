<?php if (!defined('THINK_PATH')) exit(); /*a:7:{s:89:"/www/wwwroot/lv.wyc168.com/public/../application/wycadmin/view/vipcard/vip_card_edit.html";i:1557819540;s:71:"/www/wwwroot/lv.wyc168.com/application/wycadmin/view/public/header.html";i:1555747040;s:69:"/www/wwwroot/lv.wyc168.com/application/wycadmin/view/public/menu.html";i:1555747004;s:75:"/www/wwwroot/lv.wyc168.com/application/wycadmin/view/public/headerInfo.html";i:1556608614;s:75:"/www/wwwroot/lv.wyc168.com/application/wycadmin/view/public/pageHeader.html";i:1547777422;s:73:"/www/wwwroot/lv.wyc168.com/application/wycadmin/view/public/dropDown.html";i:1547739334;s:71:"/www/wwwroot/lv.wyc168.com/application/wycadmin/view/public/footer.html";i:1555746880;}*/ ?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $title; ?></title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="/static/admin/css/bootstrap.min.css" rel="stylesheet">
<link href="/static/admin/fonts/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/static/admin/css/datatables.min.css"/>
<link href="/static/admin/css/animate.min.css" rel="stylesheet">
<link href="/static/admin/css/style.css" rel="stylesheet">
<style type="text/css">
			.xiaobiao{position: absolute;right: 10px;top: 5px;font-style: inherit;font-size: 14px;color: green;}
		</style>
</head>

<body class="pace-done">
<div class="pace  pace-inactive">
    <div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
        <div class="pace-progress-inner"></div>
    </div>
    <div class="pace-activity"></div>
</div>
<div id="wrapper" >
    <nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="http://cn.inspinia.cn/html/inspiniaen/img/profile_small.jpg">
                             </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
									<span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $adminInfo['username']; ?></strong>
                             </span> <span class="text-muted text-xs block">管理员 <b class="caret"></b></span> </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li>
                            <a href="<?php echo url('login/logout'); ?>">登出</a>
                        </li>
                    </ul>
                </div>
                <div class="logo-element">
                    W+
                </div>
            </li>
            <?php if(is_array($menuList) || $menuList instanceof \think\Collection || $menuList instanceof \think\Paginator): $i = 0; $__LIST__ = $menuList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <li <?php if($vo->controller == strtolower(\think\Request::instance()->controller())): ?> class="active" <?php endif; ?>>
            <a href="/wycadmin/<?php echo $vo->controller; ?>/<?php echo $vo->action; ?>">
                <i class="fa fa-th-large"></i> <span class="nav-label"><?php echo $vo->title; ?></span><i class='xiaobiao'></i>
            </a>
            <ul class="nav nav-second-level collapse">
                <?php if(is_array($vo->son) || $vo->son instanceof \think\Collection || $vo->son instanceof \think\Paginator): $i = 0; $__LIST__ = $vo->son;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$so): $mod = ($i % 2 );++$i;?>
                <li>
                    <a href="/wycadmin/<?php echo $so->controller; ?>/<?php echo $so->action; ?>"><?php echo $so->title; ?></a>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>


            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <!--<li>-->
            <!--<a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">新闻公告</span><span class="fa arrow"></span></a>-->
            <!--<ul class="nav nav-second-level collapse">-->
            <!--<li>-->
            <!--<a href="news.html">最新公告</a>-->
            <!--</li>-->

            <!--</ul>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">管理员列表 </span><span class="fa arrow"></span></a>-->
            <!--<ul class="nav nav-second-level collapse">-->
            <!--<li>-->
            <!--<a href="add-guanli.html">新增管理员</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="guanli-xiugai.html">管理员修改</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="quanxain-guanli.html">权限管理</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="guanli-list.html">管理员列表</a>-->
            <!--</li>-->
            <!--</ul>-->
            <!--</li>-->

            <!--<li>-->
            <!--<a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">会员管理</span><span class="fa arrow"></span></a>-->
            <!--<ul class="nav nav-second-level collapse">-->
            <!--<li>-->
            <!--<a href="huiyuan-list.html">会员列表</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="heimingdan-guanli.html">黑名单管理</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="huiyuan-jihuo.html">会员激活</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="huiyuan-zhuce.html">会员注册</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="tuijian-tuopu.html">推荐拓扑</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="huiyuan-liuyan.html">会员留言</a>-->
            <!--</li>-->

            <!--</ul>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">交易管理</span> <span class="fa arrow"></span></a>-->
            <!--<ul class="nav nav-second-level collapse">-->
            <!--<li>-->
            <!--<a href="jiaoyi-dating.html">交易大厅</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="jiaoyi-jilu.html">交易记录</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="bangzhu-jilu.html">帮助记录</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="shouyi-jilu.html">收益记录</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="yuji-shouyi.html">预计收益</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="shensu-jilu.html">申诉记录</a>-->
            <!--</li>-->

            <!--</ul>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">财务记录</span><span class="fa arrow"></span></a>-->
            <!--<ul class="nav nav-second-level collapse">-->
            <!--<li>-->
            <!--<a href="dongtai-shouyi.html">动态收益</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="caiwu-liushui.html">财务流水</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="huiyuan-chongzhi.html">会员充值</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="chongzhi-mingxi.html">充值明细</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="gongsi-koubi.html">公司扣币</a>-->
            <!--</li>-->

            <!--</ul>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">系统配置</span><span class="fa arrow"></span></a>-->
            <!--<ul class="nav nav-second-level collapse">-->
            <!--<li>-->
            <!--<a href="wangzhan-shezhi.html">网站设置</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="peizhi-guanli.html">配置管理</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="caidan-guanli.html">菜单管理</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="daohang-guanli.html">导航管理</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="shuju-chushihua.html">数据初始化</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="xingwei-rizhi.html">行为日志</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="jiangjin-shezhi.html">奖金设置</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a href="shujushezhi.html">数据设置</a>-->
            <!--</li>-->

            <!--</ul>-->
            <!--</li>-->

        </ul>

    </div>
</nav>

    <div id="page-wrapper" class="gray-bg" style="min-height: 551px;">
        <div class="row border-bottom">
    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" action="search_results.html">
                <div class="form-group">
                    <input type="text" placeholder="请输入搜索内容" class="form-control" name="top-search" id="top-search">
                </div>
            </form>
        </div>
        <!--<ul class="nav navbar-top-links navbar-right">-->
            <!--<li>-->
                <!--<span class="m-r-sm text-muted welcome-message">欢迎来到管理后台</span>-->
            <!--</li>-->
            <!--<li class="dropdown">-->
                <!--<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">-->
                    <!--<i class="fa fa-envelope"></i> <span class="label label-warning">16</span>-->
                <!--</a>-->
                <!--<ul class="dropdown-menu dropdown-messages">-->
                    <!--&lt;!&ndash;<li>&ndash;&gt;-->
                        <!--&lt;!&ndash;<div class="dropdown-messages-box">&ndash;&gt;-->
                            <!--&lt;!&ndash;<a href="profile.html" class="pull-left">&ndash;&gt;-->
                                <!--&lt;!&ndash;<img alt="image" class="img-circle" src="http://cn.inspinia.cn/html/inspiniaen/img/a7.jpg">&ndash;&gt;-->
                            <!--&lt;!&ndash;</a>&ndash;&gt;-->
                            <!--&lt;!&ndash;<div class="media-body">&ndash;&gt;-->
                                <!--&lt;!&ndash;<small class="pull-right">46小时前</small>&ndash;&gt;-->
                                <!--&lt;!&ndash;<strong>小明</strong> 评论了 <strong>小红</strong>. <br>&ndash;&gt;-->
                                <!--&lt;!&ndash;<small class="text-muted">2017.10.06 7:58</small>&ndash;&gt;-->
                            <!--&lt;!&ndash;</div>&ndash;&gt;-->
                        <!--&lt;!&ndash;</div>&ndash;&gt;-->
                    <!--&lt;!&ndash;</li>&ndash;&gt;-->
                    <!--<li class="divider"></li>-->
                    <!--<li>-->
                        <!--<div class="dropdown-messages-box">-->
                            <!--<a href="profile.html" class="pull-left">-->
                                <!--<img alt="image" class="img-circle" src="http://cn.inspinia.cn/html/inspiniaen/img/a4.jpg">-->
                            <!--</a>-->
                            <!--<div class="media-body ">-->
                                <!--<small class="pull-right text-navy">5小时前</small>-->
                                <!--<strong>小红</strong> 打电话给了 <strong>小黑</strong>. <br>-->
                                <!--<small class="text-muted">2017.10.06 7:58</small>-->
                            <!--</div>-->
                        <!--</div>-->
                    <!--</li>-->
                    <!--<li class="divider"></li>-->
                    <!--<li>-->
                        <!--<div class="dropdown-messages-box">-->
                            <!--<a href="profile.html" class="pull-left">-->
                                <!--<img alt="image" class="img-circle" src="http://cn.inspinia.cn/html/inspiniaen/img/profile.jpg">-->
                            <!--</a>-->
                            <!--<div class="media-body ">-->
                                <!--<small class="pull-right">23小时前</small>-->
                                <!--<strong>小黑</strong> 点赞了 <strong>小红</strong>. <br>-->
                                <!--<small class="text-muted">2017.10.06 7:58</small>-->
                            <!--</div>-->
                        <!--</div>-->
                    <!--</li>-->
                    <!--<li class="divider"></li>-->
                    <!--<li>-->
                        <!--<div class="text-center link-block">-->
                            <!--<a href="mailbox.html">-->
                                <!--<i class="fa fa-envelope"></i> <strong>阅读所有消息</strong>-->
                            <!--</a>-->
                        <!--</div>-->
                    <!--</li>-->
                <!--</ul>-->
            <!--</li>-->
            <!--<li class="dropdown">-->
                <!--<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">-->
                    <!--<i class="fa fa-bell"></i> <span class="label label-primary">8</span>-->
                <!--</a>-->
                <!--<ul class="dropdown-menu dropdown-alerts">-->
                    <!--<li>-->
                        <!--<a href="mailbox.html">-->
                            <!--<div>-->
                                <!--<i class="fa fa-envelope fa-fw"></i> 你有16条消息-->
                                <!--<span class="pull-right text-muted small">4 分钟前</span>-->
                            <!--</div>-->
                        <!--</a>-->
                    <!--</li>-->
                    <!--<li class="divider"></li>-->
                    <!--<li>-->
                        <!--<a href="profile.html">-->
                            <!--<div>-->
                                <!--<i class="fa fa-twitter fa-fw"></i> 3 个新的关注者-->
                                <!--<span class="pull-right text-muted small">12 分钟前</span>-->
                            <!--</div>-->
                        <!--</a>-->
                    <!--</li>-->
                    <!--<li class="divider"></li>-->
                    <!--<li>-->
                        <!--<a href="grid_options.html">-->
                            <!--<div>-->
                                <!--<i class="fa fa-upload fa-fw"></i> 重启服务器-->
                                <!--<span class="pull-right text-muted small">4 分钟前</span>-->
                            <!--</div>-->
                        <!--</a>-->
                    <!--</li>-->
                    <!--<li class="divider"></li>-->
                    <!--<li>-->
                        <!--<div class="text-center link-block">-->
                            <!--<a href="notifications.html">-->
                                <!--<strong>查看所有信息</strong>-->
                                <!--<i class="fa fa-angle-right"></i>-->
                            <!--</a>-->
                        <!--</div>-->
                    <!--</li>-->
                <!--</ul>-->
            <!--</li>-->

            <!--<li>-->
                <!--<a href="<?php echo url('login/logout'); ?>">-->
                    <!--<i class="fa fa-sign-out"></i> 注销-->
                <!--</a>-->
            <!--</li>-->
            <!--<li>-->
                <!--<a class="right-sidebar-toggle">-->
                    <!--<i class="fa fa-tasks"></i>-->
                <!--</a>-->
            <!--</li>-->
        <!--</ul>-->
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <a rel="nofollow" target="_blank" href=""><i class="fa fa-cog  "></i>清除缓存</a>
            </li>
            <li>
                <!--<a rel="nofollow" target="_blank" href="<?php echo url('rule/ruleedit'); ?>"><i class="fa fa-cog  "></i>奖金设置</a>-->
            </li>
        </ul>
    </nav>
</div>
        <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo $title; ?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">首页</a>
            </li>

            <li class="active">
                <strong><?php echo $title; ?></strong>
            </li>
        </ol>
    </div>

</div>
        <div class="wrapper wrapper-content animated fadeInDown">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?php echo $title; ?></h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>

                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content clearfix">
                            <form method="post" id="itcinfo" class="form-horizontal col-lg-6" enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">*卡片名称</label>
                                    <div class="col-sm-10"><input type="title" value="<?php echo $info->title; ?>" class="form-control"  name="title"><span class="help-block m-b-none text-danger">(名称最长32位)</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">*卡片id</label>
                                    <div class="col-sm-10"><input type="number" value="<?php echo $info->card_id; ?>" class="form-control" name="card_id"><span class="help-block m-b-none text-danger">(id填写0-127)</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">*卡片图片</label>
                                    <div class="col-sm-10"><input type="file" class="form-control" name="image"><span class="help-block m-b-none text-danger">(卡片图片 尺寸319*138)</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">*价格</label>
                                    <div class="col-sm-10"><input type="number" value="<?php echo $info->price; ?>" class="form-control" name="price"><span class="help-block m-b-none text-danger">(价格填写0-99999999)</span></div>
                                </div>
                                <input type="hidden" name="image_path" value="<?php echo $info->image_path; ?>">
                                <input type="hidden" name="id" value="<?php echo $info->id; ?>">
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">*卡片类型</label>
                                    <div class="col-sm-10">
                                        <label for="card_type1" style="display: inline-block;margin-top:7px;margin-right: 10px">
                                            <input id="card_type1" type="radio" <?php if($info->card_type == 1): ?> checked="checked" <?php endif; ?>  value="1" class="" name="card_type"> 按天数
                                        </label>
                                        <label for="card_typ2" style="display: inline-block;margin-top:7px">
                                            <input id="card_typ2" type="radio" <?php if($info->card_type == 2): ?> checked="checked" <?php endif; ?> value="2" class="" name="card_type"> 按使用次数
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">*使用次数或到期天数</label>
                                    <div class="col-sm-10"><input type="number" value="<?php echo $info->card_type_number; ?>" class="form-control" name="card_type_number"><span class="help-block m-b-none text-danger">(按卡片类型区分到期条件 只能填写1-99999)</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">*直推奖励方案</label>
                                    <div class="col-sm-10">
                                        <label for="recommend_award_type1" style="display: inline-block;margin-top:7px;margin-right: 10px">
                                            <input id="recommend_award_type1" type="radio" <?php if($info->recommend_award_type == 1): ?> checked="checked" <?php endif; ?> value="1" class="" name="recommend_award_type"> 线上购买激活后奖励
                                        </label>
                                        <label for="recommend_award_type2" style="display: inline-block;margin-top:7px">
                                            <input id="recommend_award_type2" type="radio" <?php if($info->recommend_award_type == 2): ?> checked="checked" <?php endif; ?> value="2" class="" name="recommend_award_type"> 线下购买激活后奖励
                                        </label>
                                        <label for="recommend_award_type3" style="display: inline-block;margin-top:7px">
                                            <input id="recommend_award_type3" type="radio" <?php if($info->recommend_award_type == 3): ?> checked="checked" <?php endif; ?> value="3" class=""  name="recommend_award_type"> 都不奖励
                                        </label>
                                        <label for="recommend_award_type4" style="display: inline-block;margin-top:7px">
                                            <input id="recommend_award_type4" type="radio" <?php if($info->recommend_award_type == 4): ?> checked="checked" <?php endif; ?> value="4" class="" name="recommend_award_type"> 都奖励
                                        </label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">*线上购买激活奖金</label>
                                    <div class="col-sm-10"><input type="number" value="<?php echo $info->recommend_award_price_up; ?>" class="form-control" name="recommend_award_price_up"><span class="help-block m-b-none text-danger">(奖金填写0-99999999)</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">*线下购买激活奖金</label>
                                    <div class="col-sm-10"><input type="number" value="<?php echo $info->recommend_award_price_down; ?>" class="form-control" name="recommend_award_price_down"><span class="help-block m-b-none text-danger">(奖金填写0-99999999)</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">*是否开启分销</label>
                                    <div class="col-sm-10">
                                        <label for="open0" style="display: inline-block;margin-top:7px;margin-right: 10px">
                                            <input id="open0" type="radio"  <?php if($info->open == 0): ?> checked="checked" <?php endif; ?> value="0" class="" name="open"> 否
                                        </label>
                                        <label for="open1" style="display: inline-block;margin-top:7px">
                                            <input id="open1" type="radio" <?php if($info->open == 1): ?> checked="checked" <?php endif; ?> value="1" class="" name="open"> 是
                                        </label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">*卡片介绍</label>
                                    <div class="col-sm-10"><textarea name="introduce" id="" cols="85" rows="10"><?php echo $info->introduce; ?></textarea><span class="help-block m-b-none text-danger">(最长255字)</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">*卡片攻略</label>
                                    <div class="col-sm-10"><textarea name="strategy"  cols="85" rows="10"><?php echo $info->strategy; ?></textarea><span class="help-block m-b-none text-danger">(最长255字)</span></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-white" type="button" onclick="history.back(-1)">取消</button>
                                        <button class="btn btn-primary" type="button" onclick="infoSubmit()">保存更改</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="footer">

            <div>
                <strong>Copyright</strong>
            </div>
        </div>
    </div>
    <div id="right-sidebar">
    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;">
        <div class="sidebar-container" style="overflow: hidden; width: auto; height: 100%;">

            <ul class="nav nav-tabs navs-3">

                <li class="active">
                    <a data-toggle="tab" href="#tab-1">
                        记录
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#tab-2">
                        项目
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#tab-3">
                        <i class="fa fa-gear"></i>
                    </a>
                </li>
            </ul>

            <div class="tab-content">

                <div id="tab-1" class="tab-pane active">

                    <div class="sidebar-title">
                        <h3> <i class="fa fa-comments-o"></i> 最新记录</h3>
                        <small><i class="fa fa-tim"></i> 你有10条新消息。</small>
                    </div>

                    <div>

                        <div class="sidebar-message">
                            <a href="#">
                                <div class="pull-left text-center">
                                    <img alt="image" class="img-circle message-avatar" src="http://cn.inspinia.cn/html/inspiniaen/img/a1.jpg">

                                    <div class="m-t-xs">
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                    </div>
                                </div>
                                <div class="media-body">

                                    Lorem Ipsum的通道有许多变化。
                                    <br>
                                    <small class="text-muted">今天 4:21 pm</small>
                                </div>
                            </a>
                        </div>
                        <div class="sidebar-message">
                            <a href="#">
                                <div class="pull-left text-center">
                                    <img alt="image" class="img-circle message-avatar" src="http://cn.inspinia.cn/html/inspiniaen/img/a2.jpg">
                                </div>
                                <div class="media-body">
                                    使用Lorem Ipsum的观点是它具有或多或少的正常。
                                    <br>
                                    <small class="text-muted">昨天 2:45 pm</small>
                                </div>
                            </a>
                        </div>
                        <div class="sidebar-message">
                            <a href="#">
                                <div class="pull-left text-center">
                                    <img alt="image" class="img-circle message-avatar" src="http://cn.inspinia.cn/html/inspiniaen/img/a3.jpg">

                                    <div class="m-t-xs">
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                    </div>
                                </div>
                                <div class="media-body">
                                    这些年来，有时是意外的，有时是有目的的（注入幽默等）。
                                    <br>
                                    <small class="text-muted">昨天 1:10 pm</small>
                                </div>
                            </a>
                        </div>
                        <div class="sidebar-message">
                            <a href="#">
                                <div class="pull-left text-center">
                                    <img alt="image" class="img-circle message-avatar" src="http://cn.inspinia.cn/html/inspiniaen/img/a4.jpg">
                                </div>

                                <div class="media-body">
                                    Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the
                                    <br>
                                    <small class="text-muted">星期一 8:37 pm</small>
                                </div>
                            </a>
                        </div>
                        <div class="sidebar-message">
                            <a href="#">
                                <div class="pull-left text-center">
                                    <img alt="image" class="img-circle message-avatar" src="http://cn.inspinia.cn/html/inspiniaen/img/a8.jpg">
                                </div>
                                <div class="media-body">

                                    互联网上的所有Lorem Ipsum发电机往往重复。
                                    <br>
                                    <small class="text-muted">今天 4:21 pm</small>
                                </div>
                            </a>
                        </div>
                        <div class="sidebar-message">
                            <a href="#">
                                <div class="pull-left text-center">
                                    <img alt="image" class="img-circle message-avatar" src="http://cn.inspinia.cn/html/inspiniaen/img/a7.jpg">
                                </div>
                                <div class="media-body">
                                    再生。 Lorem Ipsum的第一行“Lorem ipsum dolor sit amet ..”来自1.10.32节的一行。
                                    <br>
                                    <small class="text-muted">昨天 2:45 pm</small>
                                </div>
                            </a>
                        </div>
                        <div class="sidebar-message">
                            <a href="#">
                                <div class="pull-left text-center">
                                    <img alt="image" class="img-circle message-avatar" src="http://cn.inspinia.cn/html/inspiniaen/img/a3.jpg">

                                    <div class="m-t-xs">
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                    </div>
                                </div>
                                <div class="media-body">
                                    从1500年代以来使用的Lorem Ipsum的标准块转载如下。
                                    <br>
                                    <small class="text-muted">昨天 1:10 pm</small>
                                </div>
                            </a>
                        </div>
                        <div class="sidebar-message">
                            <a href="#">
                                <div class="pull-left text-center">
                                    <img alt="image" class="img-circle message-avatar" src="http://cn.inspinia.cn/html/inspiniaen/img/a4.jpg">
                                </div>
                                <div class="media-body">
                                    揭开许多网站仍处于起步阶段。 各种版本有。
                                    <br>
                                    <small class="text-muted">星期一 8:37 pm</small>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>

                <div id="tab-2" class="tab-pane">

                    <div class="sidebar-title">
                        <h3> <i class="fa fa-cube"></i> 最新项目</h3>
                        <small><i class="fa fa-tim"></i> 你有14个项目。 10没有完成</small>
                    </div>

                    <ul class="sidebar-list">
                        <li>
                            <a href="#">
                                <div class="small pull-right m-t-xs">9小时前</div>
                                <h4>业务估值</h4> 一个长期以来的事实是，读者会分心。

                                <div class="small">完成度: 22%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
                                </div>
                                <div class="small text-muted m-t-xs">时间: 4:00 pm - 12.06.2014</div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="small pull-right m-t-xs">9小时前</div>
                                <h4>与公司签订合同 </h4> 许多桌面出版包和网页编辑器。

                                <div class="small">完成度: 48%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 48%;" class="progress-bar"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="small pull-right m-t-xs">9小时前</div>
                                <h4>会议</h4> 通过查看其布局时页面的可读内容。

                                <div class="small">完成度: 14%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 14%;" class="progress-bar progress-bar-info"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="label label-primary pull-right">NEW</span>
                                <h4>生成的</h4> Lorem Ipsum的通道有许多变化。
                                <div class="small">完成度: 22%</div>
                                <div class="small text-muted m-t-xs">时间: 4:00 pm - 12.06.2014</div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="small pull-right m-t-xs">9小时前</div>
                                <h4>业务估值</h4> 一个长期以来的事实是，读者会分心。

                                <div class="small">完成度: 22%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
                                </div>
                                <div class="small text-muted m-t-xs">时间: 4:00 pm - 12.06.2014</div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="small pull-right m-t-xs">9小时前</div>
                                <h4>与公司签订合同 </h4> 许多桌面出版包和网页编辑器。

                                <div class="small">完成度: 48%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 48%;" class="progress-bar"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <div class="small pull-right m-t-xs">9小时前</div>
                                <h4>会议</h4> 通过查看其布局时页面的可读内容。

                                <div class="small">完成度: 14%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 14%;" class="progress-bar progress-bar-info"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="label label-primary pull-right">NEW</span>
                                <h4>生成的</h4>
                                <!--<div class="small pull-right m-t-xs">9小时前</div>-->
                                Lorem Ipsum的通道有许多变化。
                                <div class="small">完成度: 22%</div>
                                <div class="small text-muted m-t-xs">时间: 4:00 pm - 12.06.2014</div>
                            </a>
                        </li>

                    </ul>

                </div>

                <div id="tab-3" class="tab-pane">

                    <div class="sidebar-title">
                        <h3><i class="fa fa-gears"></i> 设置</h3>
                        <small><i class="fa fa-tim"></i> 你有14个项目。 10没有完成</small>
                    </div>

                    <div class="setings-item">
									<span>
                        显示通知
                    </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example">
                                <label class="onoffswitch-label" for="example">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
									<span>
                        停用聊天
                    </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="collapsemenu" checked="" class="onoffswitch-checkbox" id="example2">
                                <label class="onoffswitch-label" for="example2">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
									<span>
                        启用历史记录
                    </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example3">
                                <label class="onoffswitch-label" for="example3">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
									<span>
                        显示图表
                    </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example4">
                                <label class="onoffswitch-label" for="example4">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
									<span>
                        离线用户
                    </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" checked="" name="collapsemenu" class="onoffswitch-checkbox" id="example5">
                                <label class="onoffswitch-label" for="example5">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
									<span>
                        全球搜索
                    </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" checked="" name="collapsemenu" class="onoffswitch-checkbox" id="example6">
                                <label class="onoffswitch-label" for="example6">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
									<span>
                        每天更新
                    </span>
                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example7">
                                <label class="onoffswitch-label" for="example7">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="sidebar-content">
                        <h4>设置</h4>
                        <div class="small">
                            我相信那个 Lorem Ipsum只是印刷和排版行业的虚拟文字。 排版行业。 Lorem Ipsum自15世纪15年代以来一直是行业的标准虚拟文本。 多年来，有时偶然地，有时是目的（注入幽默等）。
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 877px;"></div>
        <div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.4; z-index: 90; right: 1px;"></div>
    </div>

</div>
</div>

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

<script type="text/javascript">
    $('.count').countUp();

    function infoSubmit() {
        var data = new FormData(document.getElementById('itcinfo'))
        ajax_Submit("",data,"post",1);
    }
</script>


</body>

</html>