<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>邮箱设置</title>

<link rel="stylesheet" type="text/css" href="__ADMIN__/Public/css/base.css" />
<script src="__ADMIN__/Public/js/jquery-1.7.1.min.js"></script>
<script src="__ADMIN__/Public/js/base.js"></script>

<script>
$(function(){
	$("input[name=lang][value=<?php echo $_GET['lang'];?>]").attr("checked",true);

	$("input[name=lang]").click(function(){
		window.location.href = '__APP__/Admin/System/index/lang/'+$(this).val()+'/cid/<?php echo $_GET["cid"];?>';
	});
});
</script>

</head>
<body>
<div class="nav-site"><?php getNavSite($c_root,$_GET['cid']);?></div>
<form action="__APP__/Admin/System/saveSetting" method="post" class="form">  
  <input type="hidden" name="id" value="<?php echo ($system["id"]); ?>">                        
   <fieldset>
       <ul class="align-list">
           <li>
               <label>SMTP 服务器</label>
               <input type="text" id="email_smtp_host" name="email_smtp_host" value="<?php echo ($system["email_smtp_host"]); ?>" class="type-text">
           </li>
           <li>
               <label>SMTP 端口号</label>
               <input type="text" id="email_smtp_port" name="email_smtp_port" value="<?php echo ($system["email_smtp_port"]); ?>" class="type-text">
           </li>
           <li>
               <label>邮箱用户名</label>
               <input type="text" id="email_username" name="email_username" value="<?php echo ($system["email_username"]); ?>" class="type-text">
           </li>
           <li>
               <label>邮箱密码</label>
               <input type="text" id="email_password" name="email_password" value="<?php echo ($system["email_password"]); ?>" class="type-text">
           </li>
           <li>
               <label>发件主题</label>
               <input type="text" id="email_subject" name="email_subject" value="<?php echo ($system["email_subject"]); ?>" class="type-text">
           </li>
           <li>
               <label>发件人邮箱</label>
               <input type="text" id="email_address" name="email_address" value="<?php echo ($system["email_address"]); ?>" class="type-text">
           </li>
           <li>
               <label>发件人名称</label>
               <input type="text" id="email_auto" name="email_auto" value="<?php echo ($system["email_auto"]); ?>" class="type-text">
           </li>
           <li>
               <label></label>
               <input type="submit" value="确定并保存" class="button button-green" />
               <input type="reset" value="重置" class="button button-red" />
            </li>
        </ul>
    </fieldset>
</form>

</body>
</html>