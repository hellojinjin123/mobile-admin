<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>后台管理</title>

<link rel="stylesheet" type="text/css" href="__ADMIN__/Public/css/base.css" />

<script src="__ADMIN__/Public/js/jquery-1.7.1.min.js"></script>
<script src="__ADMIN__/Public/js/layout/jquery.layout.js"></script>

<style type="text/css">
#top_nav_box{position: absolute;top: 49px;left: 215px;height:31px;overflow:hidden;width:1250px;}
.top-nav{list-style: none;margin:0;padding:0; position:absolute;height:31px;width:1250px;}
.nav_arrow_left{z-index:999;position: absolute;cursor:pointer;display:none;}
.nav_arrow_right{z-index:999;right:0px;position: absolute;cursor:pointer;display:none;}
.top-nav li{float:left; height:31px;background:url(__ADMIN__/Public/imgs/nav_02.jpg) no-repeat left;overflow:hidden;margin:0 1px;}
.top-nav li.home{background:url(__ADMIN__/Public/imgs/nav_01.jpg) no-repeat left;}
.top-nav li a{display:block;text-align:center; width:68px;height:31px;color: #5666a1;line-height: 31px;text-decoration:none;overflow:hidden;}

.top-nav li a:hover {background-color: #395e9f;color:#395e9f;background:url(__ADMIN__/Public/imgs/nav_01.jpg) no-repeat left;}

.header-title{width:100%;height:78px;background:url(__ADMIN__/Public/imgs/Qweb_logo.gif) no-repeat left;}
.header-title h1 {color: white;font-size: 26px;height: 24px;font-weight: bold;padding-top: 20px;padding-left: 10px;}

.ui-layout-resizer-west{background-color:#013A6F;}
.ui-layout-toggler-west{background-color:#B50033;}

</style>

<script>
var qweb_layout = null;
$(document).ready(function () {

	qweb_layout = $('body').layout({
			
			north__size: 80,
			north__fxName: "none",
			west__size:	210,
			north__spacing_open: 0
	});
	
	$('.top-nav li a#home').css({'background':'url(__ADMIN__/Public/imgs/nav_01.jpg) no-repeat left','color':'#395e9f'});

	$('#lang').val('<?php echo $_SESSION["admin"]["lang"];?>');

	$('#lang').change(function() {
		$.get('__APP__/Admin/Index/checkedLang',{'lang':$(this).val()},function(){
			//mainFrame.location.reload();
			leftFrame.location.reload();
		});
	});
	qweb_layout.close('west');
	
	//window--resize
	var nav_box_w = document.getElementById("top_nav_box").offsetWidth;
	var iNum = 215;
	var scrllo_box = $(".top-nav");
	var nav_li_first_w = $(".top-nav li:first").width();
	var body_w = 0;
	var unll_iNum = 0;
	
	function Object_resize(){
		unll_iNum = 0;
		var visible_body_w = document.body.clientWidth;
		if(visible_body_w - iNum > nav_box_w){
			scrllo_box.animate({"right":0});
			$(".nav_arrow_right,.nav_arrow_left").hide();
		}else{
			var count_w = nav_box_w -(visible_body_w - iNum);
			body_w = count_w;
			$(".nav_arrow_right").css({"right":body_w});
			$(".nav_arrow_left").css({"right":body_w + 15});
			$(".nav_arrow_right,.nav_arrow_left").show();
		}
	}
	
	Object_resize();
	
	$(window).resize(function(){
		Object_resize()
	});

	$(".nav_arrow_right").click(function(){						 
		unll_iNum += nav_li_first_w;
		var scrllo_bov_right = parseInt(scrllo_box.css("right")) + parseInt(nav_li_first_w);
		if(scrllo_bov_right > body_w){
			unll_iNum = body_w;
			scrllo_box.stop().animate({"right":unll_iNum + 30});
		}else{
			scrllo_box.stop().animate({"right":unll_iNum});
		}
	})
	$(".nav_arrow_left").click(function(){
		unll_iNum -= parseInt(nav_li_first_w);
		var scrllo_bov_right = parseInt(scrllo_box.css("right")) - parseInt(nav_li_first_w);
		if(scrllo_bov_right == 0 || scrllo_bov_right < 0){
			scrllo_box.stop().animate({"right":0});
			unll_iNum = 0;
		}else{
			scrllo_box.stop().animate({"right":unll_iNum});
		}
	})
	
});

function toURLIframe( url ){
	document.getElementById('mainFrame').src = url;
}

function goToModule(_this, main_url, left_url ) {
	$(_this).css({'background':'url(__ADMIN__/Public/imgs/nav_02.jpg) no-repeat left'});
	$('.top-nav li').removeClass("home");
	$('.top-nav li a').css({'background':'','color':'#6774A8'});
	$(_this).css({'background':'url(__ADMIN__/Public/imgs/nav_01.jpg) no-repeat left','color':'#395e9f'});
	$("#mainFrame",parent.document.body).attr("src",'__APP__/Admin/'+main_url);
	$("#leftFrame",parent.document.body).attr("src",'__APP__/Admin/'+left_url);
	if($(_this).attr('id')=='Home') {
		qweb_layout.close('west');
	} else {
		qweb_layout.open('west');
	}
	return false;
}
</script>

</head>
<body style="background:url(__ADMIN__/Public/imgs/head_bg.jpg) repeat-x">

<div class="ui-layout-north">
	<div class="header-title" >
        <h1></h1>
        <div style="float: right;margin-top: -35px;color:#fff;">
       <!-- 
            语言切换
            <select id="lang">
            <option value="all" selected="selected">全部语言</option>
            <?php if(is_array($langList)): $i = 0; $__LIST__ = $langList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["alias"]); ?>"><?php echo ($vo["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>&nbsp;&nbsp;&nbsp;
			<a href="#" style="color:#fff;" onClick="toURLIframe('__APP__/Admin/Mobile')">手机模式</a>&nbsp;&nbsp;&nbsp; -->
            <a href="#" style="color:#fff;" onClick="toURLIframe('__APP__/Admin/User/password')">修改密码</a>&nbsp;&nbsp;&nbsp;
            <a href="__APP__/Admin/Login/logout" style="color:#fff;">退出系统</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        
        <div id="top_nav_box">
            <ul class="nav_arrow_left"><img src="__ADMIN__/Public/imgs/nav_arrow_left.png"></ul>
            <ul class="nav_arrow_right"><img src="__ADMIN__/Public/imgs/nav_arrow_right.png"></ul>
            <ul class="top-nav">
                <li class="home"><a href="#" id="Home" onClick="goToModule(this,'Index/main','Index/mainMenu')">系统首页</a></li>
                
                <?php if(is_array($moduleList)): $i = 0; $__LIST__ = $moduleList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><?php if($_SESSION[C('USER_AUTH_KEY')]['superadmin']==true || in_array($vo['id'],$_SESSION['access'][$vo['modelaction']])){ ?>
                	<li><a href="#" id="<?php echo ($vo["modelaction"]); ?>" onClick="goToModule(this,'<?php echo ($vo["modelaction"]); ?>/index/mid/<?php echo ($vo["id"]); ?>','Index/sidemenu/mid/<?php echo ($vo["id"]); ?>')"><?php echo ($vo["modelname"]); ?></a></li>
                    <?php } ?><?php endforeach; endif; else: echo "" ;endif; ?>
               
                <li><a href="__APP__/<?php echo ($default_group); ?>" target="_blank" id="Home" style="color:#273E93;font-weight:bold;">网站首页</a></li>
            </ul>
        </div>
	</div>
</div>

<iframe id="mainFrame" class="ui-layout-center" width="100%" height="100%" frameborder="0" scrolling="auto" src="__APP__/Admin/Index/main"></iframe>


<iframe id="leftFrame" class="ui-layout-west" width="100%" height="100%" frameborder="0" scrolling="auto" src=""></iframe>

</body>
</html>