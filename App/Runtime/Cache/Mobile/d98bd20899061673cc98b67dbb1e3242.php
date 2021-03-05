<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($obj["title"]); ?>_案例详情</title>
<!-- layout::Inc:top::0 -->
</head>

<body>
<div data-role="page" >
<div data-role="header" id="tit">
	<a href="__APP__/Mobile/Case" data-icon="back" class="tit_btn" rel="external">返回</a>
	<h1>案例详情</h1>
	<a href="__APP__/Mobile" data-icon="home" class="tit_btn" rel="external">首页</a>
</div>

<div data-role="content" style="background:#fff; border:none;" >
  <div class="pro_data">
    <h3><?php echo ($obj["title"]); ?></h3>
    <?php if($obj["image"] != ''): ?><div><img src="__UPLOAD__/images/case/m_<?php echo ($obj["image"]); ?>" width="100%" height="100%"></div><?php endif; ?>
    <?php echo (htmlspecialchars_decode($obj["content"])); ?>
    
  </div>

 </div>

<!-- layout::Inc:footer::0 -->



</div><!--page-->
</body>
</html>