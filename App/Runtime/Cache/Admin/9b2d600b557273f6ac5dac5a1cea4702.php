<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>SEO设置</title>

<link rel="stylesheet" type="text/css" href="__ADMIN__/Public/css/base.css" />
<script src="__ADMIN__/Public/js/jquery-1.7.1.min.js"></script>
<script src="__ADMIN__/Public/js/base.js"></script>>



</head>
<body>
<div class="nav-site"><?php getNavSite($c_root,$_GET['cid']);?></div>
<form action="__APP__/Admin/System/saveSetting" method="post" class="form">   
  <input type="hidden" name="id" value="<?php echo ($system["id"]); ?>">                       
   <fieldset>
       <ul class="align-list">
           <li>
               <label>标题(Title)</label>
               <input type="text" id="seo_title" name="seo_title" value="<?php echo ($system["seo_title"]); ?>" class="type-text">
           </li>
           <li>
               <label>关键字(Keywords)</label>
               <input type="text" id="seo_keywords" name="seo_keywords" value="<?php echo ($system["seo_keywords"]); ?>" class="type-text">
           </li>
           <li>
               <label>描述(Description)</label>
               <input type="text" id="seo_description" name="seo_description" value="<?php echo ($system["seo_description"]); ?>" class="type-text">
           </li>
          
           <li>
               <label></label>
               <input type="submit" value="确定并保存" class="button button-green" />
               <input type="reset" value="重置" class="button button-red" />
            </li>
        </ul>
    </fieldset>
</form>

</body>
</html>