<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>编辑内容</title>

<link rel="stylesheet" type="text/css" href="__ADMIN__/Public/css/base.css" />
<script src="__ADMIN__/Public/js/jquery-1.7.1.min.js"></script>

<script type="text/javascript">
function Data(){
	this._APP_ = "__APP__";
	this.category_id = "<?php echo $obj['category_id'];?>";
	this.get_cid = "<?php echo $_GET['cid'];?>";
	this.get_id = "<?php echo $_GET['id'];?>";
	this.is_comment = "<?php echo $obj['is_comment'];?>";
	this.is_publish = "<?php echo $obj['is_publish'];?>";
	this.actionName = "<?php echo $actionName;?>";
}
</script>
<script src="__ADMIN__/Public/js/edit.js"></script>

</head>
<body>
<div class="nav-site"><?php getNavSite($c_root,$_GET['cid']);?></div>
<form action="__APP__/Admin/Guestbook/<?php echo $obj==null?'add':'update'; ?>" method="post" enctype="multipart/form-data" class="form">  
<input type="hidden" name="id" value="<?php echo ($obj["id"]); ?>">
<input type="hidden" name="mid" value="<?php echo ($_GET['mid']); ?>">

	<fieldset>
		<ul class="align-list">		
		<li>
		<label>留言标题 </label>
		<?php echo ($obj["title"]); ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo (date('Y-m-d H:i',$obj["create_time"])); ?>
		</li>	
		<li>
		<label>留言内容 </label>
		<?php echo ($obj["content"]); ?>
		</li>
			<li>
				<label>回复内容 </label>
				<textarea name="reply" rows="10" style="width:58%"><?php echo (htmlspecialchars_decode($obj["reply"])); ?></textarea>
			</li>
			
			<li>
				<label></label>
				<input type="submit" value="确定并保存" class="button button-green" />	
				<input type="reset" value="重置" class="button button-red" />	
				<input type="button" value="返回列表" onclick="javascript:history.go(-1);" class="button" />
			</li>
		</ul>
	</fieldset>
</form>

</body>
</html>