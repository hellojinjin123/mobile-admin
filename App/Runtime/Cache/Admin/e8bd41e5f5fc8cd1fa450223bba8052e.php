<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>编辑内容</title>

<link rel="stylesheet" type="text/css" href="__ADMIN__/Public/css/base.css" />
<script src="__ADMIN__/Public/js/jquery-1.7.1.min.js"></script>
<script src="__ADMIN__/Public/js/base.js"></script>

</head>
<body>
<div class="nav-site"><?php getNavSite($c_root,$_GET['cid']);?> > 用户管理 > 添加管理员</div>
<form action="__APP__/Admin/<?php echo $actionName;?>/<?php echo $obj==null?'add':'update'; ?>" method="post" class="form" >  
<input type="hidden" name="id" value="<?php echo ($obj["id"]); ?>">
   <fieldset>
       <ul class="align-list">
           <li>
               <label>用户名</label>
               <input type="text" id="username" name="user_name" value="<?php echo ($obj["username"]); ?>"  class="type-text">
           </li>
           <li>
           	 <label>密码</label>
             <input type="password" id="password" name="password" value="" class="type-text">
           </li>
           <li>
           	 <label>昵称</label>
             <input type="text" id="realname" name="realname" value="<?php echo ($obj["realname"]); ?>" class="type-text">
           </li>
           <li>
           	 <label>备 注</label>
             <textarea id="info" name="info" cols="100" rows="3"><?php echo ($obj["remark"]); ?></textarea>
           </li>
           <li>
               <label>现在启用?</label>
               <input type="checkbox" id="is_publish" name="is_publish" value="1" checked="checked">
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