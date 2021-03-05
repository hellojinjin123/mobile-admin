<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($category['title']); ?>_产品分类</title>
<!-- layout::Inc:top::0 -->

</head>

<body>
<div data-role="page" id="mainPage" >
	<div data-role="header" id="tit" data-position="fixed">
		<a href="__APP__/Mobile/Goods" data-icon="back" class="tit_btn" rel="external">返回</a>
		<h1><?php echo ($category['title']); ?></h1>
		<a href="__APP__/Mobile" data-icon="home" class="tit_btn" rel="external">首页</a>
	</div>

	<div data-role="content" style="background:#fff; border:none;" >
	
	<div style="margin-bottom:2%;">
	    <ul data-role="listview" id="pagelist"> 
	    
		
		
	</ul> 
	</div>
	<input type="hidden" id="pages" value="1">
	<input type="hidden" id="is_end" value="0">
	<input type="hidden" id="pagesize" value="<?php echo ($pagesize); ?>">
	
	<div data-role="controlgroup"  data-type="horizontal" id="more" style="display:none;text-align:center;padding-top:20px;width:200px;margin:0px auto;">
	  
	  <p>加载更多，请稍候...</p>
	</div>
	
	
	 </div>

 <script> 
 var m_url = '__MOBILE__'; 
 var a_url= '__APP__'; 
 var cid = '<?php echo ($_GET['cid']); ?>'; 
 var actionname = '<?php echo ($actionName); ?>' ;
 var is_endLast = false;
	 $(window).on('load', function(){
		 
		 showLoader();			
		 $.ajax({
			  type: "POST",
			  url: a_url+"/Mobile/Ajaxload/start_ajaxLoad",
			  data: 'cid='+cid+'&actionName='+actionname,
			  cache: false,
			  
			  success: function(data){
			  		
			 		hideLoader(); 
			 		var res = eval("("+data+")");
			 		 
				    $("#pagelist").append(res.str);
				    $("#pagelist").trigger("create"); 
				    if(res.more==1){		    					    
				    	$('#more').show()
				    }
			  }
			});	
	});
 
 </script>
 
 <script src="__MOBILE__/js/list.loading.js"></script>
 <!-- layout::Inc:footer::0 -->



</div><!--page-->
</body>
</html>