<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($system["seo_title"]); ?></title>

<!-- layout::Inc:top::0 -->

<script type="text/javascript" src="__MOBILE__/js/jquery.flexslider.js"></script>
<link rel="stylesheet" type="text/css" href="__MOBILE__/css/flexslider.css" />
<script>

jQuery(document).on('pagebeforeshow','#index', function(){
	
	 $.ajax({
		  url: "__APP__/Mobile/Ajaxload/index_advajaxload",
		  cache: false,
		  success: function(data){
		 		
			    $(".slides").html(data);
			    $('#flexslider').flexslider({
				    animation: "slide",
				    keyboard:false,
				    scale:2		});
			    
		  }
		});	
		
});


</script>
</head>

<body>

<div data-role="page" id="index" >
<div data-role="header"  style="background:#fff; border:none;">
<div class="header">
  <div class="qy_logo"> <img src="__MOBILE__/images/logo.jpg" alt="" /></div>
  <div class="dh">
    服务热线
    <span><?php echo ($system["telephone"]); ?></span>
  </div>  <div class="clear"></div> 
</div>

<div class="main">
	<div class="pro-switch">
		<div style="width:100%;height:100%;margin:0px;"><!-- flexslide -->
	
			<div class="flexslider"  id ='flexslider' STYLE="border:5px solid #ccc;box-shadow:0px 0px 5px #aaa;">
			  <ul class="slides"> </ul>
			</div>
			<div style="clear:both"></div>	
		</div>		
	</div>
</div>


</div>

<div data-role="content" style="background:#fff; border:none;" >
 <div class="content">
   <ul>
     <li><div class="btn"><a href="__APP__/Mobile/About" rel="external"><img src="__MOBILE__/images/home_btn2.png" width="60" height="59" alt=""></a>
       <p>关于我们</p></div></li>
     <li><div class="btn"><a href="__APP__/Mobile/Goods" rel="external"><img src="__MOBILE__/images/home_btn4.png" width="60" height="59" alt=""></a>
       <p>产品服务</p></div></li>
     <li><div class="btn"><a href="__APP__/Mobile/News" rel="external"><img src="__MOBILE__/images/home_btn6.png" width="60" height="59" alt=""></a>
       <p>新闻资讯</p></div></li>
     <li><div class="btn"><a href="__APP__/Mobile/Case" rel="external"><img src="__MOBILE__/images/home_btn5.png" width="60" height="59" alt=""></a>
       <p>成功案例</p></div></li>
     <li><div class="btn"><a href="__APP__/Mobile/Contact" rel="external"><img src="__MOBILE__/images/home_btn1.png" width="60" height="59" alt=""></a>
       <p>联系我们</p></div></li>
     <li><div class="btn"><a href="__APP__/Mobile/Message" rel="external"><img src="__MOBILE__/images/home_btn7.png" width="60" height="59" alt=""></a>
       <p>在线留言</p></div></li>
        <div class="clear"></div>
   </ul>

 </div>
 </div>



<!-- layout::Inc:footer::0 -->
<script>



</script>
</div>


</body>
</html>