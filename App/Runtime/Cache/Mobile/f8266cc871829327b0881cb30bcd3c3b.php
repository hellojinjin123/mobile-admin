<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>联系我们</title>
<!-- layout::Inc:top::0 -->
</head>

<body>
<div data-role="page">
<div data-role="header" id="tit">
	<a href="__APP__/Mobile" data-icon="back" class="tit_btn" rel="external">返回</a>
	<h1>联系我们</h1>
	<a href="__APP__/Mobile" data-icon="home" class="tit_btn" rel="external">首页</a>
</div>

<div data-role="content" style="background:#fff; border:none;" >

				
	<?php echo (htmlspecialchars_decode($obj["content"])); ?>


  
 </div>


<!-- layout::Inc:footer::0 -->



</div><!--page-->
</body>
</html>