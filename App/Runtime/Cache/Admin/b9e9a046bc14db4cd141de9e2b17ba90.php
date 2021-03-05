<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>用户授权</title>

<link rel="stylesheet" type="text/css" href="__ADMIN__/Public/css/base.css" />
<script src="__ADMIN__/Public/js/jquery-1.7.1.min.js"></script>
<script src="__ADMIN__/Public/js/base.js"></script>

<script type="text/javascript">
$(function(){
	$('input[type=checkbox]').change(function(){
		$.getJSON('__APP__/Admin/User/accredit', {'admin_id':"<?php echo $obj['id']; ?>",'nodes':$(this).val(),'checked':$(this).attr('checked')}, function(json){
			console.log($(this).val());
		});
	});

	<?php 
		foreach( $nodesList as $key=>$value ) {
		$nodes = $value['nodes'];
		$index = strpos($nodes,'-');
		$nodes = substr($nodes, $index+1);
	?>
	$("input[name='<?php echo $nodes ?>']").attr('checked', true);
	<?php } ?>
});
</script>
<style type="text/css">
.borders{ border-bottom:1px solid #999;padding-bottom:5px;}
</style>
</head>
<body>
<h2><?php echo ($obj["username"]); ?> 用户授权</h2>
<form action="__APP__/Admin/User/accredit_save" method="post" class="form">  
<input type="hidden" name="id" value="<?php echo ($obj["id"]); ?>">
<input type="hidden" name="uid" value="<?php echo ($uid); ?>">
   <fieldset>
       <table border="0" width="100%" cellpadding="0" cellspacing="0">
       
       <?php if(is_array($moduleList)): $i = 0; $__LIST__ = $moduleList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><?php $model_access = $access[$vo['modelaction']]; ?>
       <tr><td><label><input type="checkbox" name="<?php echo ($vo["modelaction"]); ?>[]" value="<?php echo ($vo["id"]); ?>" <?php if(in_array($vo['id'],$model_access)){ echo 'checked'; } ?> ><?php echo ($vo["modelname"]); ?></label></td></tr>
       <tr><td class="borders" style="padding-left:30px;">
       
	       <?php $onecate = Categorylist(1,$vo['id']); ?>
	       <ul>
	       <?php if(is_array($onecate)): $i = 0; $__LIST__ = $onecate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$one): $mod = ($i % 2 );++$i;?><?php $twocate = Categorylist($one['id'],$one['model_id']); ?>
	       
	       <?php if($twocate != '' ): ?><li><label><input type="checkbox" name="<?php echo ($vo["modelaction"]); ?>[]" value="<?php echo ($one["id"]); ?>" <?php if(in_array($one['id'],$model_access)){ echo 'checked'; } ?> > <?php echo ($one["title"]); ?></label>
	       
		       
		       <ul style="padding-left:90px;">
		       <?php if(is_array($twocate)): $i = 0; $__LIST__ = $twocate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$two): $mod = ($i % 2 );++$i;?><li><input type="checkbox" name="<?php echo ($vo["modelaction"]); ?>[]" value="<?php echo ($two["id"]); ?>" <?php if(in_array($two['id'],$model_access)){ echo 'checked'; } ?>> <?php echo ($two["title"]); ?><br>
			       	<?php $threecate = Categorylist($two['id'],$two['model_id']);  
				       	if($threecate){
				       		$str ='<div style="padding:10px 0 15px 30px;">';
				       		foreach($threecate as $value){
				       			$str .= '<input type="checkbox" name="'.$vo['modelaction'].'[]" value="'.$value['id'].'" ';
				       			if(in_array($value['id'],$model_access)){
				       				$str .= 'checked';
				       			}
				       			$str .='/>'.$value['title'].'&nbsp;&nbsp;&nbsp;&nbsp;';
				       		}
				       		$str .= '</div>';
				       		echo $str;
				       	} ?>
			       		
			       			
			       </li><?php endforeach; endif; else: echo "" ;endif; ?>
		       
		       </ul>
	       </li>
	       <?php else: ?>
	       <label><input type="checkbox" name="<?php echo ($vo["modelaction"]); ?>[]" value="<?php echo ($one["id"]); ?>" <?php if(in_array($one['id'],$model_access)){ echo 'checked'; } ?> > <?php echo ($one["title"]); ?></label><?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
	       
	       <li><label><input type="checkbox" name="<?php echo ($vo["modelaction"]); ?>[]" value="category"  > 分类管理</label></li>
	       </ul>
       </td></tr><?php endforeach; endif; else: echo "" ;endif; ?>
       <tr><td align="center">
       
       <input type="submit" value="确定并保存" class="button button-green" />
               <input type="reset" value="重置" class="button button-red" />
       
       </td></tr>
       </table>
    </fieldset>
</form>


</body>
</html>