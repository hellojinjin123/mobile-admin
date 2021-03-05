<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>编辑分类</title>

<link rel="stylesheet" type="text/css" href="__ADMIN__/Public/css/base.css" />
<script src="__ADMIN__/Public/js/jquery-1.7.1.min.js"></script>

<script src="__ADMIN__/Public/js/base.js"></script>



</head>
<body>

<div class="nav-site"> > 编辑分类</div>
<form action="__APP__/Admin/Category/categoryManage" method="post" enctype="multipart/form-data" class="form"> 
                        
  <fieldset>
      <ul class="align-list">
      	   <li>
  	 		  <div id="msg_category" style="display:none;line-height:30px;text-align:center;height:30px;color:#fff;"></div>
   		   </li>
   		   
   		   <?php if($act!='update'){ ?>
   		   <li>
            <label>上级分类</label>
            <select name="fid" id="fid">
           	  <option value="1" >无上级分类</option>
           	  <?php if(is_array($categoryList)): $i = 0; $__LIST__ = $categoryList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if($vo['id']==$_GET['id']){ echo 'selected'; } ?> ><?php echo ($vo["title"]); ?></option>
           	  <?php $threecate = getCate($vo['id']); ?>
           	    <?php if(is_array($threecate)): $i = 0; $__LIST__ = $threecate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vs): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vs["id"]); ?>" <?php if($vs['id']==$_GET['id']){ echo 'selected'; } ?> >&nbsp;&nbsp;|--<?php echo ($vs["title"]); ?></option>
           	    <?php $fourcate = getCate($vs['id']); ?>
           	    <?php if(is_array($fourcate)): $i = 0; $__LIST__ = $fourcate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php if($v['id']==$_GET['id']){ echo 'selected'; } ?> >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|--<?php echo ($v["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?><?php endforeach; endif; else: echo "" ;endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
           </li>
           <?php } ?>
           
   		   <li>
               <label>分类名称</label>
               <input type="text" id="title" name="title" value="<?php echo ($catedata["title"]); ?>" class="type-text">
           </li>
           <li>
       	 	<label>描述</label>
       	 	<textarea id="description" name="description" cols="100" rows="3"><?php echo ($catedata["description"]); ?></textarea>
       	 	</li>
       	 	
       	   <li>
               <label>显示方式</label>
               <input type="radio" name="tpl_one" value="list" <?php if($catedata['tpl_one']=='list'){ echo 'checked'; }elseif(!isset($catedata)){ echo 'checked'; } ?> > 列表
                <input type="radio" name="tpl_one" value="one" <?php if($catedata['tpl_one']=='one'){ echo 'checked'; } ?> > 单页
           </li>
           
          
           <li>
               <label></label>
               <input type="hidden" id="mid" name="model_id" value="<?php echo ($_GET['mid']); ?>">
               <input type="hidden" id="id" name="id" value="<?php echo ($catedata["id"]); ?>">
               <input type="hidden" id="act" name="act" value="<?php echo ($act); ?>">
               <input type="submit" value="确定并保存" class="button button-green" />
               <input type="reset" value="重置" class="button button-red" />
			   <input type="button" value="返回列表" onclick="goToUrl('');" class="button" />
            </li>
        </ul>
    </fieldset>
</form>

<!--  </if>-->

</body>
</html>