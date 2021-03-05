<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>默认左侧菜单</title>

<link rel="stylesheet" href="__ADMIN__/Public/css/base.css" type="text/css" />
<script src="__ADMIN__/Public/js/jquery-1.7.1.min.js"></script>

<style type="text/css">
body{background-color:#F6F7F9;}
#sidemenu{background-color:#F6F7F9;}
#sidemenu ul {font-size: 12px;line-height: 20px;}
#sidemenu li {position: relative;border-bottom: 1px solid #DCE7F0;}
#sidemenu a {display: block;color: #596677;padding: 9px 26px 9px 15px;border-top: 1px solid #F6F7F9;border-bottom: 1px solid #F6F7F9;text-decoration: none;}
#sidemenu a img {margin-bottom: -4px;margin-right: 9px;}
#sidemenu a:hover,.checked-action {text-decoration: none;background: #EDF1F5;color: #3F4C59;border-top: 1px solid #DCE7F0;border-bottom: 1px solid #DCE7F0;}
#sidemenu .submenu li{border-bottom: none;}
#sidemenu .submenu a {padding: 5px 12px 5px 30px;}
#sidemenu .submenu .submenu a {padding: 5px 12px 5px 60px;}
.submenu {padding: 0px;padding-bottom: 6px;display: none;}
.subtitle .action .arrow {position: absolute;right: 10px;top: 18px;}
</style>

<script>
$(document).ready(function () {

	$("#sidemenu li.subtitle a.action").toggle(
	  function () {
		  $(this).addClass('checked-action');
		  $(this).siblings("ul").show();
	  }, 
	  function () {
		  $(this).removeClass('checked-action');
		  $(this).siblings("ul").hide();
	  }
	);

	$('.openMain').click(function(){
		parent.toURLIframe($(this).attr('href'));
		return false;
	});
	
});
</script>

</head>
<body>

<div id="sidemenu">
  <ul>
  	<?php if(is_array($dataList)): $i = 0; $__LIST__ = $dataList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$one): $mod = ($i % 2 );++$i;?><?php $access = $_SESSION['access'][$one['modelaction']]; ?>
  		<?php if(empty($one['is_child'])): ?><?php if($_SESSION[C('USER_AUTH_KEY')]['superadmin']==true || in_array($one['id'],$access)){ ?>
  			<li><a href="__APP__/Admin/<?php getAction($one['model_id']);?>/<?php getMenuUrl($one);?>" class="openMain"><?php echo ($one["title"]); ?></a></li>
  			
  			<?php } ?>
  		<?php else: ?>
  		
  			<?php if($_SESSION[C('USER_AUTH_KEY')]['superadmin']==true || in_array($one['id'],$access)){ ?>
  			<li class="subtitle">
    			<a class="action openMain" href="__APP__/Admin/<?php getAction($one['model_id']);?>/<?php getMenuUrl($one);?>""><?php echo ($one["title"]); ?><img src="__ADMIN__/Public/imgs/arrow-down.png" width="7" height="4" alt="arrow" class="arrow"> </a>
		  		<?php $slaveColumn = getslaveColumn($one['id']); ?>
		  		<?php if(is_array($slaveColumn)): $i = 0; $__LIST__ = $slaveColumn;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$two): $mod = ($i % 2 );++$i;?><ul class="submenu" style="display:none;">
		  			<?php if(empty($two['is_child'])): ?><?php if($_SESSION[C('USER_AUTH_KEY')]['superadmin']==true || in_array($two['id'],$access)){ ?>
		  				<li><a href="__APP__/Admin/<?php getAction($two['model_id']);?>/<?php getMenuUrl($two);?>"" class="openMain"><?php echo ($two["title"]); ?></a></li>
		  				<?php } ?>
		  			<?php else: ?>
		  				<?php if($_SESSION[C('USER_AUTH_KEY')]['superadmin']==true || in_array($two['id'],$access)){ ?>
						<li class="subtitle">
				        	<a class="action openMain" href="__APP__/Admin/<?php getAction($two['model_id']);?>/<?php getMenuUrl($two);?>"" class="openMain"><?php echo ($two["title"]); ?><img src="__ADMIN__/Public/imgs/arrow-down.png" width="7" height="4" alt="arrow" class="arrow"> </a>
				        	<?php $slaveColumn2 = getslaveColumn($two['id']); ?>
				        	<ul class="submenu" style="display:none;">
				        		<?php if(is_array($slaveColumn2)): $i = 0; $__LIST__ = $slaveColumn2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$three): $mod = ($i % 2 );++$i;?><?php if($_SESSION[C('USER_AUTH_KEY')]['superadmin']==true || in_array($three['id'],$access)){ ?>
				        			<li><a href="__APP__/Admin/<?php getAction($three['model_id']);?>/<?php getMenuUrl($three);?>"" class="openMain"><?php echo ($three["title"]); ?></a></li>
				        			 <?php } ?><?php endforeach; endif; else: echo "" ;endif; ?>
				        	</ul>
				        </li>
				        <?php } ?><?php endif; ?>
		  		</ul><?php endforeach; endif; else: echo "" ;endif; ?>
	  		</li>
	  		<?php } ?><?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
    <?php if($_SESSION[C('USER_AUTH_KEY')]['superadmin']==true || in_array('category',$access)){ ?>
    <li><a href="__APP__/Admin/Category/index/mid/<?php echo ($mid); ?>" class="openMain">分类管理</a></li>
    <?php } ?>
  </ul>
</div>
</body>
</html>