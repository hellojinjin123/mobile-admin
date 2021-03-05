<?php if (!defined('THINK_PATH')) exit();?><div class="nav">
  <ul>
  <!--
    <li><a href="__APP__">首 页</a></li>
    <li><a href="__APP__/About">关于柏历</a></li>
    <li><a href="__APP__/Brand">品牌介绍</a></li>
    <li><a href="__APP__/Product">产品展示</a></li>
    <li><a href="__APP__/News">最新动态</a></li>
    <li><a href="__APP__/Market">服务网点</a></li>
    <li><a href="__APP__/Join/sustain.html">在线加盟</a></li>
    <li><a href="__APP__/Guestbook">在线留言</a></li>
    <li><a href="__APP__/Contact">联系我们</a></li> -->
     <?php if(is_array($part)): $i = 0; $__LIST__ = $part;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><?php if(($vo["now"])  ==  $now): ?><li class="now"><a href="<?php echo ($vo["url"]); ?>"><?php echo ($vo["title"]); ?></a>
        	<?php else: ?>
            	<li><a href="<?php echo ($vo["url"]); ?>"><?php echo ($vo["title"]); ?></a><?php endif; ?>
        <?php if(!empty($vo["next"])): ?><!-- 下一级 -->
        		<ul>
               <?php if(is_array($vo["next"])): $i = 0; $__LIST__ = $vo["next"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tt): $mod = ($i % 2 );++$i;?><li><a class="nextPart" href="<?php echo ($tt["url"]); ?>" onClick="addNav(false,<?php echo ($tt["id"]); ?>)" va="<?php echo ($tt["id"]); ?>"><?php echo ($tt["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
               </ul><?php endif; ?>
        </li><?php endforeach; endif; else: echo "" ;endif; ?>
  </ul>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(".nav ul li").hover(function(){
			$(this).find("ul").show(0);
		}, function(){
			$(this).find("ul").hide(0);
		});
	})
</script>