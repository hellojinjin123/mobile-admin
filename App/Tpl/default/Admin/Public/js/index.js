var data = new Data();

$(function(){

	$("#rowpage").val(data.rowpage);
	
	//全选/返选
	$("#chk_all").click(function(){
	     $("input[name='ids[]']").attr("checked",this.checked);
	});

	//排序
	$("#on_ordernum").click(function(){
		if(window.tipCheckbox()) {
			$("#form_list").attr('action',data._APP_+'/Admin/'+data.actionName+'/ordernum/cid/'+data.get_cid);
			$("#form_list").submit();
		}
	});

	//移动
	$("#on_move").click(function(){
		
		if(window.tipCheckbox()) {
			
			$('#category_button').val('移动');
			$("#form_list").attr('action',data._APP_+'/Admin/'+data.actionName+'/move');
			window.openCategoryBox();
		}
	});

	//复制
	$("#on_copy").click(function(){
		if(window.tipCheckbox()) {
			$('#category_button').val('复制');
			$("#form_list").attr('action',data._APP_+'/Admin/'+data.actionName+'/copy');
			window.openCategoryBox();
		}
	});

	//移动和复制按钮,检查分类有没有选择
	$('#category_button').click(function(){
		if($('#one_category_id').get(0).options.length>1 && $('#one_category_id').val()=='') {
			alert('一级分类未选择！');
			return false;
		}/*
		if($('#two_category_id').get(0).options.length>1 && $('#two_category_id').val()=='') {
			alert('二级分类未选择！');
			return false;
		}
		if($('#three_category_id').get(0).options.length>1 && $('#three_category_id').val()=='') {
			alert('三级分类未选择！');
			return false;
		}*/
	});

	//删除
	$("#on_delete").click(function(){
		if(window.tipCheckbox()) {
			if(confirm('确认删除勾选的数据吗？删除后无法恢复！')) {
				$("#form_list").attr('action',data._APP_+'/Admin/'+data.actionName+'/delete');
				$("#form_list").submit();
			} else {
				return false;
			}
		}
	});

	//搜索
	$("#search_button").click(function(){
		var searchKey = $('#searchKey').val();
		if(searchKey == '请输入关键字' || jQuery.trim(searchKey)=='') {
			alert('请输入搜索关键字！');
			return false;
		}
		window.location.href = window.getSearchUrl();
	});

	//每页显示行数
	$("#rowpage").change(function(){
		var url = window.getSearchUrl();
		
		window.location.href = url;
		
	});

	//发布状态
	$("input[name=is_publish]").click(function(){
		window.updateField('isPublish',$(this).attr('value'), this.checked);
	});

	//首页状态
	$("input[name=is_home]").click(function(){
		window.updateField('isHome',$(this).attr('value'), this.checked);
	});

	//置顶状态
	$("input[name=is_top]").click(function(){
		window.updateField('isTop',$(this).attr('value'), this.checked);
	});
	
	//表格变色
	$('.grid-table tbody tr').hover(
	  function () {
	    $(this).css('background-color','#FCF4DA');
	  }, 
	  function () {
		  $(this).css('background-color','');
	  }
	);
	
	$('body').append('<div id="opt_msg"></div>');
});

//更新单个字段
function updateField(action,id, fval) {
	var url =data._APP_+'/Admin/'+data.actionName+'/'+action+'/id/'+id+'/fval/'+fval+'/cid/'+data.get_cid;
	var mes = null,opt_msg = null;
	$.get(url,{},function(bool){
		if( bool==1 ) {
			opt_msg = $("#opt_msg").css("background-color","#319E01").text('状态已改变');
		} else if( bool == 'no-access') {
			opt_msg = $("#opt_msg").css('background-color','#D50D0D').text('没有权限');
		}else {
			opt_msg = $("#opt_msg").css('background-color','#D50D0D').text('状态未改变');
		}
		opt_msg.show().animate({left: '+=50%'}, 100).delay(2000).animate({left: '-=50%'}, 100).fadeOut(100);
	});
}

//返回搜索URL
function getSearchUrl() {
	return data._APP_+'/Admin/'+data.actionName+'/index/rowpage/'+$('#rowpage').val()+'/searchKey/'+$('#searchKey').val()+'/mid/'+data.c_root+'/cid/'+data.get_cid;
}

//搜索获取蕉点清空文字
function inputText(_this,defText) {
	if(_this.value == defText){
		_this.value = '';
		return;
	}
	if(_this.value == '') {
		_this.value = defText;
	}
}

//移动或复制分类选择
function openCategoryBox(){
	
	$('#category_box').fadeOut(0).fadeIn();
	$.getJSON(data._APP_+"/Admin/Index/selectCategoryByPid",{"mid":data.c_root},function(json){
		$('#one_category_id').html('');
		$('#one_category_id').append('<option value="" selected>请选择</option>');
		$(json.list).each(function(i,obj){
			//alert(obj);
			var str_tr = '<option value="'+obj.id+'">'+obj.title+'</option>';
			$('#one_category_id').append(str_tr);
		});
	});
}

//批量操作未选择checkbox提示
function tipCheckbox() {
	var n = $("input[name='ids[]']:checked").length;
	if( n==0 ) {
		alert('还没有勾选数据呢！');
		return false;
	} else {
		return true;
	}
}

//分类下拉联动---------------------------------------------------------------
function changeCategory(_this,target_id){
	if( target_id=='two_category_id' ) {
		$('#three_category_id').html('');
		$('#three_category_id').append('<option value="" selected>请选择</option>');
	}
	var id = $(_this).val();
	$.getJSON(data._APP_+"/Admin/Index/getslaveCategory",{"fid":id},function(json){
		//alert(json.list);
		if(json.loop==1){
			$('#'+target_id).show();
			$('#'+target_id).html('');
			$('#'+target_id).append('<option value="" selected>请选择</option>');
			$(json.list).each(function(i,obj){
				var str_tr = '<option value="'+obj.id+'">'+obj.title+'</option>';
				$('#'+target_id).append(str_tr);
			});
		}else{
			$('#'+target_id).hide();
		}
	});
}

//删除数据
function deleteData(url) {
	if(confirm('确认删除数据吗？删除后无法恢复！')) {
		window.location.href = url;
	} else {
		return false;
	}
}

//手机同步
function synchMobile(id) {
	window.location.href=data._APP_+'/Admin/'+data.actionName+'/synchMobile/id/'+id;
}
