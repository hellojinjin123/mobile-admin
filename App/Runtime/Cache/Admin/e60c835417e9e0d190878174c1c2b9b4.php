<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>默认数据表格</title>
<link rel="stylesheet" type="text/css" href="__ADMIN__/Public/css/base.css" />
<link rel="stylesheet" type="text/css" href="__ADMIN__/Public/css/guestbook.css" />
<script src="__ADMIN__/Public/js/jquery-1.7.1.min.js"></script>

<script>
function Data(){
	this._APP_ = "__APP__";
	this.c_root = "<?php echo $c_root; ?>";
	this.get_cid = "<?php echo $_GET['cid']?>"
	this.rowpage = "<?php echo $rowpage; ?>";
	this.actionName = "<?php echo $actionName;?>";
}

$(document).ready(function(){

	$('#select-filter').change(function(){
		window.location.href = $(this).val();
	});	

	$('.show_toggle').click(function(){		
		$this = $(this);
		var guestbook_content = $this.parent().parent().next();

		if(guestbook_content.is(":hidden")){			
			$this.text('收起');

			var hidden = $this.next()
			var guestbook_id = hidden.val();

			if(guestbook_id.length > 0){				
				$.get("__APP__/Admin/Guestbook/mark_read/id/"+guestbook_id);
				hidden.val('');
			} 

			//标记已读
			var already_read = $this.parent().next();
			already_read.text('是');
			guestbook_content.show(300);
		} else {
			$this.text('查看');
			guestbook_content.hide(300);
		}
		return false;
	});
	
});
</script>
<script src="__ADMIN__/Public/js/index.js"></script>

</head>
<body>
<div class="nav-site"><?php getNavSite($c_root,$_GET['cid']);?></div>
<form action="__APP__/Admin/Guestbook" method="post" id="form_list">
<input type="hidden" name="cid" value="<?php echo $_GET["cid"];?>" />
<table class="grid-function" border="0" cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<th width="600">
<!-- 				<div class="qw-fl grid-add-data">
					<a href="__APP__/Admin/Guestbook/edit/cid/<?php echo $_GET["cid"];?>"><input type="button" value="添加招聘" class="button button-red" /></a>
				</div> -->
				<div class="qw-fl grid-batch-operate">
					<!--  <a href="#" id="on_move" title="移动数据"><img src="__ADMIN__/Public/imgs/move.png" align="top" /> </a>&nbsp;&nbsp;-->
					<a href="#" id="on_delete" title="彻底删除"><img src="__ADMIN__/Public/imgs/delete.png" align="top" /> </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

					<?php 
					function decide_selected($status,$val){
						if($_GET['status'] === $status && $_GET['val'] === $val ) {
							echo 'selected';
						}
					} ?>
					<!--  
					过滤：
				<select id="select-filter">
					<option value="__APP__/Admin/Guestbook/index" >所有状态</option>
					<option value="__APP__/Admin/Guestbook/query/status/reply/val/0/cid/<?php echo $_GET["cid"];?>" <?php echo decide_selected('reply','0');?> >未回复</option>
					<option value="__APP__/Admin/Guestbook/query/status/reply/val/1/cid/<?php echo $_GET["cid"];?>" <?php echo decide_selected('reply','1');?> >已回复</option>
					<option value="__APP__/Admin/Guestbook/query/status/varify/val/0/cid/<?php echo $_GET["cid"];?>" <?php echo decide_selected('varify','0');?> >未审核</option>
					<option value="__APP__/Admin/Guestbook/query/status/varify/val/1/cid/<?php echo $_GET["cid"];?>" <?php echo decide_selected('varify','1');?> >已审核</option>
				</select>	-->				
				</div>
				<div class="qw-fr">
					<input name="searchKey" id="searchKey" value="<?php echo ($searchKey); ?>" onclick="inputText(this,'请输入关键字');" onblur="inputText(this,'请输入关键字');" class="grid-search-input" /> <input type="button" value="搜索" class="button" id="search_button" />
				</div>
			</th>
		</tr>
	</thead>
	<!-- 移动和复制操作分类选择 -->
	<tbody id="category_box" style="display:none;">
		<tr>
			<td align="center">选择分类
				<select id="one_category_id" name="one_category_id" style="width:200px;" onchange="changeCategory(this,'two_category_id')">
	              <option value="" selected="">请选择</option>
	            </select>
	            <input type="submit" value="" class="button button-green" id="category_button" />
			</td>
		</tr>
	</tbody>
</table>
<table class="grid-table" border="1" cellpadding="0" cellspacing="0"> 
	<thead> 
		<tr >
			<th width="15"><input type="checkbox" id="chk_all"></th>			
		    <th style="text-align:center">标题</th>
		    <th width="50px">详细信息</th>
		    <th width="30px" align="center">已读</th>
		    <th width="50px">留言类型</th>		    
		    <th width="30px" align="center">审核</th>
		    <th width="100px" align="center">操作</th>
		</tr> 
	</thead> 
	<tbody>
		<?php if(!empty($dataList)): ?><?php if(is_array($dataList)): $i = 0; $__LIST__ = $dataList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr> 
					<td><input type="checkbox" name="ids[]" id="ids<?php echo ($vo["id"]); ?>" value="<?php echo ($vo["id"]); ?>"></td>
				    <td>
				    	<?php echo ($vo["title"]); ?>
				    </td>
				    <td align="center" >
				    	<a href=""  style="color:red;" class="show_toggle"  >查看</a>
				    	<input type="hidden" value="<?php echo ($vo["id"]); ?>">
				    </td>
				    <td align="center">
				    	<?php if($vo["read"] == 0): ?>否 <?php else: ?> 是<?php endif; ?>
				    </td>
				    <td align="center"><?php getCategoryTitle($vo['category_id']);?></td>
				    <td align="center"><?php getCheckboxState($vo['id'],'is_publish',$vo['is_publish']);?></td>
				    <td>
				    	<!--  
				        <a href="__APP__/Admin/Guestbook/edit/mid/<?php echo ($_GET['mid']); ?>/cid/<?php echo ($vo["category_id"]); ?>/id/<?php echo ($vo["id"]); ?>"><img src="__ADMIN__/Public/imgs/edit.png" />回复</a>
				    	-->
				    	<a href="#" onclick="javascript:deleteData('__APP__/Admin/Guestbook/deleteById/mid/<?php echo ($_GET['mid']); ?>/id/<?php echo ($vo["id"]); ?>');"><img src="__ADMIN__/Public/imgs/cross.png" />删除</a>
				    </td>
				</tr>
				<tr id="tr_<?php echo ($vo["id"]); ?>"  style="display:none;">
					<td colspan="2">
						<div class="guest-content">
							<p><strong>内容：</strong></p>
							<?php echo ($vo["content"]); ?>
							<div class="guest-date" >发表于: <strong><?php echo (date("Y-m-d",$vo["create_time"])); ?> </strong></div>
						</div>
						<?php if(!empty($vo['reply'])): ?><div class="guest-reply" >
								<strong>回复:</strong>
								<?php echo ($vo["reply"]); ?>
								<div class="guest-date" >回复于:<strong><?php echo (date("Y-m-d",$vo["reply_time"])); ?></strong></div>
							</div><?php endif; ?>
					</td>
					<td colspan="5" valign="top">
						<ul class="guest-detail guest-detail-item">
							
							<li> 邮箱：</li>
							<li> 电话：</li>
							
						</ul>
						<ul class="guest-detail">
							
							<li><?php echo ($vo["email"]); ?></li>
							<li><?php echo ($vo["tel"]); ?></li>
							
						</ul>

					</td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		<?php else: ?>
			<tr>
				<td colspan="10" align="center" style="color:red;">该分类下没有留言。</td>
			</tr><?php endif; ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="12">
				<div class="qw-fl">
					<select name="rowpage" id="rowpage">
						<option value="10">显示10条</option>
						<option value="25">显示25条</option>
						<option value="50">显示50条</option>
						<option value="99999">显示所有</option>
					</select>
				</div>
				<div class="qw-fr">
					<div class="grid-pagination">
					<?php echo ($pageBar); ?>
					</div>
				</div>
			</td>
		</tr>
	</tfoot>
</table>
</form>

</body>
</html>