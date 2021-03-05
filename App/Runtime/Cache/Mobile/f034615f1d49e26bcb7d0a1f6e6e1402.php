<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>关于我们</title>
<!-- layout::Inc:top::0 -->
</head>

<body>
<div data-role="page" id="wrapper" class="jqm-demos">

<div data-role="header" id="tit">
	<a href="__APP__/Mobile" data-icon="back" class="tit_btn" rel="external">返回</a>
	<h1>关于我们</h1>
	<a href="__APP__/Mobile" data-icon="home" class="tit_btn" rel="external">首页</a>
</div>

<div data-role="content" style="background:#fff; border:none;" >
   <div data-role="collapsible-set" data-content-theme="d">
    <div class=" about_con">
				<?php echo (htmlspecialchars_decode($obj["content"])); ?>
</div>
			</div>
  
 </div>


<!-- layout::Inc:footer::0 -->



</div><!--page-->
</body>
</html>