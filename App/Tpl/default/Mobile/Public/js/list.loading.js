

//显示加载器  
function showLoader() {  
			var limg = '<img src="'+m_url+'/images/loaderc.gif" width="32" height="32"><span style="line-height:32px;float:right;">努力加载中,请稍候...</span>';    
		    var theme = 'd' || $.mobile.loader.prototype.options.theme,
			    msgText = '努力加载中...' || $.mobile.loader.prototype.options.text,
			    textVisible = true || $.mobile.loader.prototype.options.textVisible,
			    textonly = false;
			    html = limg;
				$.mobile.loading( "show", {
				             text: msgText,
				             textVisible: textVisible,
				             theme: theme,
				             textonly: textonly,
				             html: html
				});
}  
	  
//隐藏加载器.for jQuery Mobile 1.1.0  
function hideLoader() {  
	//隐藏加载器   
	$.mobile.loading( "hide" );
}

//scrollstart事件
function scrollstartFunc(evt) {
	try
	{
		var target = $(evt.target);
		while (target.attr("id") == undefined) {
			target = target.parent();
		}
		//获取触点目标id属性值
		var targetId = target.attr("id");
		return targetId;
		
	}
	catch (e) {
		alert('myscrollfunc：' + e.message);
	}
}


function pageLoading(loop){
	if(loop==true){
		var load  = '<img src='+m_url+'"/images/loaderc.gif" width="32" height="32"><span style="line-height:32px;float:right;">&nbsp;正在加载，请稍候...</span>';
		$('#more').html(load);
		$("#more").trigger("create");
	}else{
		var load  = '<p>加载更多，请稍候...<p>';
		$('#more').html(load);
		$("#more").trigger("create");
	}
			
}

function end_load2(){
	var load  = '<p>已全部加载完毕</p>';
	
	$('#more').html(load);
	$("#more").trigger("create");
}

$(document).ready(function(){

	
	//绑定上下滑动事件
	$("#mainPage").bind('scrollstart', function () { 

		var pid = scrollstartFunc(event); 
		var pages = $('#pages').val() * 1;
		var pagesize = $('#pagesize').val() * 1;
		var nextpage = pages + 1;
		var leng = (pages * pagesize) - pid ;
		
		if(leng<4){
			pageLoading(true);
			
			$.ajax({
	    		   type: "POST",
	    		   url: a_url+"/Mobile/Ajaxload/ajaxload",
	    		   data: "cid="+cid+"&page="+nextpage+"&actionName="+actionname,
	    		   success: function(res){
						if($('#is_end').val()==1){ 
							end_load2();
							return false;
						}
	    				var data = eval("("+res+")");			    		     				    		     			    	
	    				
		    		    $('#pages').val(nextpage);
		    		    $('#pagelist').append(data.str);
	    		     	$("#pagelist").trigger("create");
	    		     	if(data.end==1){
	    		     		end_load2();
	    		     		$('#is_end').val(data.end);
	    		     		return ;
		    		    }else{
	    		     		pageLoading(false);
		    		    }
	    		   }
	    		});
		}else{
			return ;
		}
					
	});

});

