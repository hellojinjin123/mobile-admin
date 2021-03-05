var data = new Data();

$(function(){

	if(data.get_id=='') {
		$("input[name=is_publish]").attr("checked",true);
	}
	
	//再次检查当前最后分类有没有下级分类并再次读取
	if($('#three_category_id').val()=='-1') {
		if($('#two_category_id').val()!='-1') {
			window.changeCategory($('#two_category_id'), 'three_category_id', data.lang);
		} else {
			if($('#one_category_id').val()!='-1') {
				window.changeCategory($('#one_category_id'), 'two_category_id', data.lang);
			}
		}
	}

	$("input[name=is_comment][value="+data.is_comment+"]").attr("checked",true);
	$("input[name=is_publish][value="+data.is_publish+"]").attr("checked",true);

	
	//展开表单元素
	$('#more_options').change(function() {
		if( $(this).is(':checked') ) {
			$('#more_options_box').show();
		} else {
			$('#more_options_box').hide();
		}
	});
	
	$('#more_seo').change(function() {
		if( $(this).is(':checked') ) {
			$('#more_seo_box').show();
		} else {
			$('#more_seo_box').hide();
		}
	});

	//有封面文章使用
	$('#delete_image').click(function(){
		if( confirm('确定要删除封面吗？') ) {
			$.get(data._APP_+'/Admin/'+data.actionName+'/deleteImage',{'id':data.get_id},function(bool){
				if( bool==1 ) {
					$('#span_image').css('display','none');
				}
			});
		}
	});
	
	//表单提交有分类需要选择提示
	$(':submit[name=save]').click(function(event){
		if($('#one_category_id').is(':visible')) {
			if($('#one_category_id').val()==-1) {
				alert('请选择分类！');
				$('#one_category_id').focus();  
				//event.preventDefault();
			}
		}
	});
	
	
	
	
		
});

//分类下拉联动---------------------------------------------------------------
function changeCategory(_this,target_id){
	if( target_id=='two_category_id' ) {
		$('#three_category_id').hide();
		
	}
	var id = _this.value;
	
	$.getJSON(data._APP_+"/Admin/Index/getslaveCategory",{"fid":id},function(json){
		
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

