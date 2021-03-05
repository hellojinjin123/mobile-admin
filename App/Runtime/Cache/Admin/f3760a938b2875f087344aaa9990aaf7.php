<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台登录</title>
<link href="__ADMIN__/Public/css/login.css" rel="stylesheet" type="text/css" />
<SCRIPT  src="__ADMIN__/Public/js/DD_belatedPNG.js" type=text/javascript></SCRIPT>
<script type="text/javascript"> DD_belatedPNG.fix('.login_bg'); </script>
<script type="text/javascript"> DD_belatedPNG.fix('.login_news_text04'); </script>

<script>

function fleshVerify(type){ 
	//重载验证码
	var timenow = new Date().getTime();
	if (type){
		document.getElementById('verifyImg').src= '__APP__/Admin/Login/verify/adv/1/'+timenow;
	}else{
		document.getElementById('verifyImg').src= '__APP__/Admin/Login/verify/'+timenow;
	}
}

function onLoginSubmit() {
	var form = document.login_form;
	if (form.username.value=="")
	{
		alert("提示：用户名不能为空!");
		form.username.focus();
		return false;
	}
	if (form.password.value=="")
	{
		alert("提示：密码不能为空!");
		form.password.focus();
		return false;
	}	
	if (form.verify.value=="")
 	{
		alert("提示: 请输入验证码！");
		form.verify.focus();
		return false;
 	}
	form.submit();
}

document.onkeydown = function(e) {  
    var theEvent = e || window.event;  
    var code = theEvent.keyCode || theEvent.which || theEvent.charCode;  
    if (code == 13) {  
    	document.login_form.submit();
        return false;  
    }  
    return true;  
}  
</script>

</head>
<body>

<form method="post" name="login_form" id="login_form" action="__APP__/Admin/Login/checkLogin">
<div id="bg">
  <div class="login_bg">
    <div class="login_center">
      <div class="login_news_text01">
        <input name="username" id="username" value="" type="text" style="width:180px; color:#000; font-size:13px; border:0px; background:none; padding-left:3px; font-weight:bold; font-family:Arial, Helvetica, sans-serif;" />
      </div>
      <div class="login_news_text02">
        <input name="password" id="password" value="" type="password" style="width:180px; color:#000; font-size:13px; border:0px; background:none; padding-left:3px; font-weight:bold; font-family:Arial, Helvetica, sans-serif;" />
      </div>
      <div class="login_news_text03">
        <div class="login_news_text031">
          <input name="verify" maxlength="5" type="text" value="" style="width:90px; color:#000; font-size:13px; border:0px; background:none; padding-left:3px; font-weight:bold; font-family:Arial, Helvetica, sans-serif;" />
        </div>
        <div class="login_news_text032"><img id="verifyImg" src="__APP__/Admin/Login/verify/" onClick="fleshVerify()" border="0" ALT="点击刷新验证码" style="cursor:pointer" align="absmiddle" width="83" height="25"></div>
      </div>
      <div class="login_news_text04"><a href="#" onclick="onLoginSubmit()"><img src="__ADMIN__/Public/imgs/login.png" width="90" height="23" border="0" style="margin-right:4px;" /></a><a href="#"><img src="__ADMIN__/Public/imgs/reset.png" width="90" height="23" border="0" /></a></div>
    </div>
    <div class="login_news"><a href="#" target="_blank"></a> </div>
    <div class="login_copyright">版权所有.<a href="#" target="_blank" style="color:#98C2EA">jmh</a>.</div>
  </div>
</div>
</form>

</body>
</html>