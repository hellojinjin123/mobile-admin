<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>首页切换图片编辑</title>

<!-- layout::Inc:edit_page::0 -->
<script src="__PUBLIC__/js/swfobject.js"></script>

</head>
<body>

<div class="nav-site"><?php getNavSite($c_root,$_GET['cid']);?> > 编辑信息</div>
<form action="__APP__/Admin/Advert/<?php echo $obj==null?'add':'update'; ?>" method="post" enctype="multipart/form-data" class="form">  
   <input type="hidden" name="id" value="<?php echo ($obj["id"]); ?>">
	<input type="hidden" name="mid" value="<?php echo ($_GET['mid']); ?>">
   <fieldset>
       <ul class="align-list">
       		
           <li>
               <label>广告位名称</label>
               <input type="text" id="title" name="title" value="<?php echo ($obj["title"]); ?>" class="type-text">
           </li>
           <li><label>广告位置</label>
			
           	<select name="one_category_id">
           	<option value="">请选择</option>
           	<?php $category = getAdverCatelist($_GET['mid']); ?>
           	<?php if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if($vo['id']==$obj['category_id']){ echo 'selected'; }elseif($vo['id']==$_GET['cid']){ echo 'selected'; } ?> ><?php echo ($vo["title"]); ?> </option><?php endforeach; endif; else: echo "" ;endif; ?>
           	</select>
           	
           </li>
           <li>
               <label>广告图片</label>
               <?php if( !empty($obj['image']) ) { ?>
               <span id="span_image">
			   <img alt="" align="middle" height="80" src="<?php echo __PUBLIC__.'/data/upload/images/advert/s_'.$obj['image']; ?>">
           	   <a href="javascript:void(0)" id="delete_image" style="color:red;text-decoration:underline;">删除封面</a>&nbsp;&nbsp;&nbsp;&nbsp;
           	   </span>
           	   <?php } ?>
			    <input type="file" name="image">
			    宽：<input name="imgwidth" value="300" style="width:50px;">&nbsp;&nbsp;
			    高：<input name="imgheight" value="300" style="width:50px;"> <span style="color:#999;">(缩略图显示尺寸)</span>
           </li>
           <li>
               <label>网络图片</label>
               <input type="text" id="net_image" name="net_image" value="<?php echo ($obj["net_image"]); ?>" class="type-text">
           </li>
           <li>
               <label>跳转URL</label>
               <input type="text" id="url" name="url" value="<?php echo ($obj["url"]); ?>" class="type-text">
           </li>
           <li>
               <label>现在发布<a href="#" class="issue" title="在网站前台显示">?</a></label>
               <input type="checkbox" id="is_publish" name="is_publish" checked="checked" value="1">
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