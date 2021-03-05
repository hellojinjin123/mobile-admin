<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>分类管理</title>
<link rel="stylesheet" type="text/css" href="__ADMIN__/Public/css/base.css" />
<script src="__ADMIN__/Public/js/jquery-1.7.1.min.js"></script>
<script src="__ADMIN__/Public/js/base.js"></script>

<script>
function Data(){
	this._APP_ = "__APP__";
	this.c_root = "<?php echo $c_root; ?>";
	this.get_cid = "<?php echo $_GET['cid']; ?>"
	this.actionName = "Category";
}

//删除跳转
function godelUrl(url){
	if(confirm('确认删除？')){
		window.location.href = url;
	}
	
}
</script>
<script src="__ADMIN__/Public/js/index.js"></script>

</head>
<body>
<div class="nav-site"><?php getNavSite($_GET['mid'],'');?> > 分类管理</div>
<form action="" method="post" id="form_list">
<input type="hidden" name="cid" value="<?php echo $_GET["cid"];?>" />
<table class="grid-function" border="0" cellpadding="0" cellspacing="0">
	<thead>
		
	</thead>
	<!-- 移动和复制操作分类选择 -->
	<tbody id="category_box" style="display:none;">
		
	</tbody>
</table>

<table class="grid-table" border="1" cellpadding="0" cellspacing="0"> 
	<thead> 
		<tr>
			<th width="15"><input type="checkbox" id="chk_all"></th>
		    <th>分类名称</th>
		   
		    
		    
			
		    <th width="180">操作</th>
		</tr> 
	</thead> 
	<tbody>
			<?php if(is_array($categoryList)): $i = 0; $__LIST__ = $categoryList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
		      <td><input type="checkbox" name="ids[]" id="ids<?php echo ($vo["id"]); ?>" value="<?php echo ($vo["id"]); ?>"></td>
		      <td><strong><?php echo ($vo["title"]); ?></strong></td>
		      
		      
			  <!--  <td align="center"></td>-->
		      <td align="right">
		      [<a href="__APP__/Admin/Category/edit/act/addsubclass/mid/<?php echo ($vo["model_id"]); ?>/id/<?php echo ($vo["id"]); ?>">添加子分类</a>] &nbsp; 
		      [<a href="__APP__/Admin/Category/edit/act/update/mid/<?php echo ($vo["model_id"]); ?>/id/<?php echo ($vo["id"]); ?>">编辑</a>] &nbsp;
		          <a href="#" onclick="godelUrl('__APP__/Admin/Category/delete/mid/<?php echo ($vo["model_id"]); ?>/id/<?php echo ($vo["id"]); ?>');" style="visibility:hidden" >[删除]</a></td>
		    </tr>
		    <?php getslaveCate($vo['id']);?><?php endforeach; endif; else: echo "" ;endif; ?>
	    
	    
	</tbody>
</table>
</form>

</body>
</html>