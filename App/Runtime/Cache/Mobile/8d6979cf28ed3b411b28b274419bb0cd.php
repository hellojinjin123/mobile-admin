<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>产品服务</title>
<!-- layout::Inc:top::0 -->
</head>

<body>
<div data-role="page" >
<div data-role="header" id="tit" data-position="fixed">
	<a href="__APP__/Mobile" data-icon="back" class="tit_btn" rel="external">返回</a>
	<h1>产品服务</h1>
	<a href="__APP__/Mobile" data-icon="home" class="tit_btn" rel="external">首页</a>
</div>

<div data-role="content" style="background:#fff; border:none;" >
    <ul data-role="listview">
      <?php if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="__APP__/Mobile/Goods/view/cid/<?php echo ($vo["id"]); ?>" rel="external"><?php echo ($vo["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
     
    </ul>
 </div>

<!-- layout::Inc:footer::0 -->



</div><!--page-->
</body>
</html>