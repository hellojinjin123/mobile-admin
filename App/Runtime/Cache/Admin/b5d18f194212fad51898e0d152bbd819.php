<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>编辑内容</title>

<!-- layout::Inc:edit_page::0 -->
<!-- layout::Inc:ueditor::0 -->

<script>


function delPic(m,n,h){
	var mid = '#'+m;
	
	$('td').remove(mid);  
	
	var imgs = $("#muitlphoto").val();
	var imgary = imgs.split(',');
	var imgres = '';
	for(var i=0;i<imgary.length;i++){
		if(n!=imgary[i]){
			imgres += imgary[i]+',';
		}
	}
	$("#muitlphoto").val(imgres);
	var delid = $('#delphotoid').val();
	if(delid!=''){ var did = delid+','+h }else{ var did =h}
	$('#delphotoid').val(did);
	
	
} 

function setView(data,tit,idstr){

	var picary  = data.split(',');
	var titary  = tit.split(',');
	var idary   = idstr.split(',');
	var imgstr = '';
	imgstr += "<table border=0>";
	for(var i=0;i<picary.length;i++){
		
		if(picary[i]!=''){
			
			if(titary[i]== undefined ){ var title = '' }else{ var title = titary[i] }
			if(idary[i]== undefined ){ var pid = '' }else{ var pid = idary[i] }
			if(i%6==0){imgstr += "<tr>";}
			imgstr += "<td id='view"+i+"' style='border:1px solid #ccc;text-align:center;padding:2px;'>";
			imgstr += "<img src='__PUBLIC__/data/upload/images/goods/"+picary[i]+"' width='120' height='120' style='border:1px solid #ccc'/> &nbsp;&nbsp;&nbsp;&nbsp;<br>";
			imgstr += "标题：<input name='phototitle[]' value='"+title+"' size='10' style='border:1px solid #cccccc;width:80px;height:24px;'/> <a href='javascript:delPic(\"view"+i+"\",\""+picary[i]+"\",\""+pid+"\")'><img src='__ADMIN__/Public/imgs/delete.png' alt='删除'/></a>";
			imgstr += "<input type='hidden' name='photofilename[]' value='"+picary[i]+"'/>";
			imgstr += "<input type='hidden' name='photofileid[]' value='"+pid+"'/>";
			imgstr += "</td>";
			if((i+1)%6==0 || i== (picary.length-1) ){imgstr += '</tr>';}
		}				
	}
	imgstr += "</table>";
	
	return imgstr;
}

function openChild(url){  
	var childwin = window.showModalDialog(url,window,"dialogWidth:482px;status:no;dialogHeight:399px"); 
	
	if(childwin != null) { 
		var oldpic = $('#muitlphoto').val();
		var title = $('#mphototitle').val();
		var idstr = $('#photoid').val();
		var newpic = oldpic + ','+ childwin;
		
		$('#muitlphoto').val(newpic) ;
		var imgs = setView(newpic,title,idstr);
		
		$('#views').html(imgs);		
		$('#photoview').show();
	}
} 

function check(){
	if($('#title').val()==''){
		alert('请输入产品名称');
		return false;
	}	
}

$(document).ready(function(){
	var pic = $('#muitlphoto').val();
	var title = $('#mphototitle').val();
	var idstr = $('#photoid').val();
	var imgs = setView(pic,title,idstr);	
	$('#views').html(imgs);		
	$('#photoview').show();
});
</script>

</head>
<body>
<div class="nav-site"><?php getNavSite($c_root,$_GET['cid']);?> > 编辑信息</div>
<form action="__APP__/Admin/Goods/<?php echo $obj==null?'add':'update'; ?>" method="post" enctype="multipart/form-data" class="form">  
<input type="hidden" name="id" value="<?php echo ($obj["id"]); ?>"> 
<input type="hidden" name="mid" value="<?php echo ($_GET['mid']); ?>">
                             
   <fieldset>
       <ul class="align-list">
       
       	    
			
           <li>
               <label>产品名称</label>
               <input type="text" id="title" name="title" value="<?php echo ($obj["title"]); ?>" class="type-text">
           </li>
           <li><label>产品分类</label>
           <?php getCateList($obj['category_id'],$_GET['mid']);?>
           	
           </li>
           <li>
               <label>产品简介</label>
                
				<textarea id="content" name="content" style="margin-left:200px;margin-left:140px;margin-top:-25px;margin-bottom:10px;width:890px;"><?php echo (htmlspecialchars_decode($obj["content"])); ?></textarea>
		    <br/>		     
		    <script type="text/javascript">
		        var editor_a = new baidu.editor.ui.Editor();		
		        //渲染编辑器		        
		        editor_a.render('content');		        
		    </script>
				
           </li>
           <li>
               <label>简介摘要</label>
               <textarea id="summary" name="summary" cols="100" rows="3"><?php echo ($obj["summary"]); ?></textarea>
           </li>
           <li>
               <label>封面</label>
               <?php if( !empty($obj['image']) ) { ?>
               <span id="span_image">
			   <img alt="" align="middle" height="80" vspace="5" src="<?php echo __PUBLIC__.'/data/upload/images/product/s_'.$obj['image']; ?>">
           	   <a href="javascript:void(0)" id="delete_image" style="color:red;text-decoration:underline;">删除封面</a>&nbsp;&nbsp;&nbsp;&nbsp;
           	   </span>
           	   <?php } ?>
			    <input type="file" name="image">
			    宽：<input name="imgwidth" value="300" style="width:50px;">&nbsp;&nbsp;
			    高：<input name="imgheight" value="300" style="width:50px;"> <span style="color:#999;">(列表显示尺寸)</span>
           </li>
           <li style="padding:5px;">
               <label>批量传图片</label>
               <?php 
               		$goodsphoto = get_GoodsPhotos($obj['id']);
					foreach($goodsphoto as $value){
						$photostr .= $value['image'].',';
						$titlestr .= $value['title'].',';
						$idstr    .= $value['id'].',';
					}

               ?>
              <input name="muitlphoto" id="muitlphoto" type="hidden" value="<?php echo $photostr;?>"  size="80" />
              <input name="mphototitle" id="mphototitle" type="hidden" value="<?php echo $titlestr;?>" >
              <input name="photoid" id="photoid" type="hidden" value="<?php echo $idstr;?>">
              <input name="delphotoid" id="delphotoid" type="hidden" value="">
               <a href="javascript:void(0)" onclick="openChild('__APP__/Admin/Goods/upload/')">[点此批量传图片]</a>
			   
           </li>
           <li id="photoview" style="display:none">
               <label>图片预览</label>
              	<div id="views" style="margin-left:130px;"></div>
			   
           </li>
           <li><div class="more-title"><input type="checkbox" id="more_options"> 更多可选项</div></li>
           <div id="more_options_box" class="more-box hide" >
 
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
           <li><div class="more-title"><input type="checkbox" id="more_seo"> 搜索引擎优化(SEO)</div></li>
           <div id="more_seo_box" class="more-box hide">
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
               <input type="submit" value="确定并保存" name="save" class="button button-green" onclick="return check()"/>
               <input type="reset" value="重置" class="button button-red" />
               <input type="button" value="返回列表" onclick="javascript:history.go(-1);" class="button" />
               
            </li>
        </ul>
    </fieldset>
</form>

</body>
</html>