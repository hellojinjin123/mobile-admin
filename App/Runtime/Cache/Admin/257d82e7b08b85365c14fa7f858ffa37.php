<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>编辑内容</title>

<!-- layout::Inc:edit_page::0 -->
<!-- layout::Inc:ueditor::0 -->

</head>
<body>
<div class="nav-site"><?php getNavSite('',$_GET['cid']);?> > 编辑信息</div>
<form action="__APP__/Admin/Case/<?php echo $obj==null?'add':'update'; ?>" method="post" enctype="multipart/form-data" class="form">  
<input type="hidden" id="id" name="id" value="<?php echo ($obj["id"]); ?>">
<input type="hidden" name="mid" value="<?php echo ($_GET['mid']); ?>">

   <fieldset>
       <ul class="align-list">
       		
			
           <li>
               <label>标题</label>
               <input type="text" id="title" name="title" value="<?php echo ($obj["title"]); ?>" class="type-text">
           </li>
           <li><label>信息分类</label>
           <?php getCateList($obj['category_id'],$_GET['mid']);?>
           	
           </li>
           <li>
               <label>内容详细</label>
               
          <!--style给定宽度可以影响编辑器的最终宽度-->
		    <textarea id="content" name="content" style="margin-left:200px;margin-left:140px;margin-top:-25px;margin-bottom:10px;width:890px;"><?php echo (htmlspecialchars_decode($obj["content"])); ?></textarea>
		    <br/>		     
		    <script type="text/javascript">
		        var editor_a = new baidu.editor.ui.Editor();		
		        //渲染编辑器		        
		        editor_a.render('content');		        
		    </script>
		   </li>
           <li>
               <label>内容摘要</label>
               <textarea id="summary" name="summary" cols="100" rows="3"><?php echo ($obj["summary"]); ?></textarea>
           </li>
           <li>
               <label>封面</label>
               <?php if( !empty($obj['image']) ) { ?>
               <span id="span_image">
			   <img alt="" align="middle" height="80" vspace="5" src="<?php echo __PUBLIC__.'/data/upload/images/case/s_'.$obj['image']; ?>">
           	   <a href="javascript:void(0)" id="delete_image" style="color:red;text-decoration:underline;">删除封面</a>&nbsp;&nbsp;&nbsp;&nbsp;
           	   </span>
           	   <?php } ?>
			    <input type="file" name="image">
			    宽：<input name="imgwidth" value="300" style="width:50px;">&nbsp;&nbsp;
			    高：<input name="imgheight" value="300" style="width:50px;"> <span style="color:#999;">(缩略图显示尺寸)</span>
           </li>
           <?php if(!empty($obj['author']) || !empty($obj['source']) || !empty($obj['tag'])){ $more_loop= true; }else{ $more_loop=false; } ?>
           <li><hr><div class="more-title"><input type="checkbox" id="more_options" <?php if($more_loop==true){ echo 'checked'; } ?>> 更多可选项</div></li>
           <div id="more_options_box" <?php if($more_loop==true){ echo 'class="more-box"'; }else{ echo 'class="more-box hide"'; } ?>>
           <li>
               <label>作者</label>
               <input type="text" id="author" name="author" value="<?php echo ($obj["author"]); ?>" class="type-text">
           </li>
           <li>
               <label>来源</label>
               <input type="text" id="source" name="source" value="<?php echo ($obj["source"]); ?>" class="type-text">
           </li>
           <li>
               <label>标签</label>
               <input type="text" id="tag" name="tag" value="<?php echo ($obj["tag"]); ?>" class="type-text">
           </li>
           <li>
               <label>更新时间</label>
               <input type="text" id="update_time" name="update_time" onClick="WdatePicker()" value="<?php echo (!isset($obj['update_time'])) ? date('Y-m-d') : date('Y-m-d', $obj['update_time']);?>" class="type-text">
           </li>
           <li>
               <label>发布时间</label>
               <input type="text" id="create_time" name="create_time" onClick="WdatePicker()" value="<?php echo (!isset($obj['create_time'])) ? date('Y-m-d') : date('Y-m-d', $obj['create_time']);?>" class="type-text">
           </li>
           </div>
           <?php if(!empty($obj['seo_title']) || !empty($obj['seo_keywords']) || !empty($obj['seo_description'])){ $seo_loop= true; }else{ $seo_loop=false; } ?>
           <li><div class="more-title"><input type="checkbox" id="more_seo" <?php if($seo_loop==true){ echo 'checked'; } ?> > 推广信息(SEO)</div></li>
           <div id="more_seo_box" <?php if($seo_loop==true){ echo 'class="more-box"'; }else{ echo 'class="more-box hide"'; } ?> >
           <li>
               <label>页面标题<br>(Title)</label>
               <input type="text" id="seo_title" name="seo_title" value="<?php echo ($obj["seo_title"]); ?>" class="type-text">
           </li>
           <li>
               <label>页面关键字<br>(Keywords)</label>
               <input type="text" id="seo_keywords" name="seo_keywords" value="<?php echo ($obj["seo_keywords"]); ?>" class="type-text">
           </li>
           <li>
               <label>页面描述<br>(Description)</label>
               <input type="text" id="seo_description" name="seo_description" value="<?php echo ($obj["seo_description"]); ?>" class="type-text">
           </li>
           </div>
		  						
           
           <li>
               <label>现在发布<a href="#" class="issue" title="在网站前台显示">?</a></label>
               <input type="checkbox" id="is_publish" name="is_publish" value="1">
           </li>
           <li>
               <label></label>
               <input type="submit" value="确定并保存" name="save" class="button button-green" />
               <input type="reset" value="重置" class="button button-red" />
               <input type="button" value="返回列表" onclick="javascript:history.go(-1);" class="button" />
            </li>
        </ul>
    </fieldset>
</form>

</body>
</html>