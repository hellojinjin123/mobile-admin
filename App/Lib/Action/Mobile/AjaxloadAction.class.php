<?php

class AjaxloadAction extends MobileAction{
	
	function _initialize() {
		parent::_initialize();										
	}
		
	function ajaxload(){
	
			$page = isset($_POST['page'])?$_POST['page']:'1';
			$pagesize = C('PAGE_SZIE');
			$prepage = ($page-1) * $pagesize;
			$nextpage = $page+1;
			$where['_string'] = "category_id like '".$_POST['cid']."%'";
			
			$model = M($_REQUEST['actionName']);
			$count = $model->where($where)->count();
			$totalpage = ceil($count/$pagesize);
					
			$obj = $model->where($where)->limit("$prepage,$pagesize")->order('id desc')->select();	
			$sql= $model->getlastsql();	
			$str = '';							
			$j= $pagesize* ($page-1) + 1;
			if($obj){
				foreach($obj as $val){
																	
					if(!empty($val['image'])){
						
						$str .= '<li id="'.$j.'" data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="d" class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-li-has-thumb ui-first-child ui-btn-up-d"><div class="ui-btn-inner ui-li"><div class="ui-btn-text">';
						$str .= '<a href="'.__APP__.'/Mobile/'.$_REQUEST['actionName'].'/show/cid/'.$val['category_id'].'/id/'.$val['id'].'.html" class="ui-link-inherit">';
	            		$str .= '<img src="'.__ROOT__.'/Public/data/upload/images/'.strtolower($_REQUEST['actionName']).'/s_'.$val['image'].'" class="ui-li-thumb">';
	               	 	$str .= '<h3 class="ui-li-heading">'.$val['title'].'</h3>';               
	                	$str .= '<p class="ui-li-desc">'.mb_substr(strip_tags(htmlspecialchars_decode($val['content'])),0,100,'utf-8').'</p>';           
	            		$str .= '</a></div><span class="ui-icon ui-icon-arrow-r ui-icon-shadow">&nbsp;</span></div></li>';
						
					}else{
						$str .= '<li id="'.$j.'" data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="d" class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-last-child ui-btn-up-d"><div class="ui-btn-inner ui-li"><div class="ui-btn-text">';
						$str .= '<a href="'.__APP__.'/Mobile/'.$_REQUEST['actionName'].'/show/cid/'.$val['category_id'].'/id/'.$val['id'].'.html" class="ui-link-inherit">';
	                	$str .= '<h3 class="ui-li-heading">'.$val['title'].'</h3>';	                	
	                	$str .= '<p class="ui-li-desc">'.mb_substr(strip_tags(htmlspecialchars_decode($val['content'])),0,100,'utf-8').'</p>';	                
	            		$str .= '</a></div><span class="ui-icon ui-icon-arrow-r ui-icon-shadow">&nbsp;</span></div></li>';
					}
						
					$j++;	
				}			
			}
		
			if($page==$totalpage){ 
				$end = 1; 
			}else{ 
				$end=0; 
			}		
			
			echo json_encode(array('str'=>$str,'end'=>$end));
	}
	
	function index_advajaxload(){
		
		$advs = M('Advert')->limit('5')->order('id asc')->select();
		foreach($advs as $value){
			if(!empty($value['url'])){
				$str .= '<li><a href="'.$value['url'].'" rel="external"><img src="'.__ROOT__.'/Public/data/upload/images/advert/m_'.$value['image'].'" alt="" />	</a>	</li>';	
			}else{
				$str .= '<li><img src="'.__ROOT__.'/Public/data/upload/images/advert/m_'.$value['image'].'" alt="" />	</li>';	
				
			}		
		}
		echo $str;
	}
	
	function start_ajaxLoad(){
		
		$where['_string'] = "category_id like '".$_POST['cid']."%'";
		$count = M($_POST['actionName'])->where($where)->count();
		$product = M($_POST['actionName'])->where($where)->limit('0,'.C('PAGE_SZIE'))->order('id desc')->select();
		$j=1;
		$str = '';
		foreach($product as $val){
				if(!empty($val['image'])){
					
					$str .= '<li id="'.$j.'" data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="d" class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-li-has-thumb ui-first-child ui-btn-up-d"><div class="ui-btn-inner ui-li"><div class="ui-btn-text">';
					$str .= '<a href="'.__APP__.'/Mobile/'.$_POST['actionName'].'/show/cid/'.$val['category_id'].'/id/'.$val['id'].'.html" class="ui-link-inherit">';
            		$str .= '<img src="'.__ROOT__.'/Public/data/upload/images/'.strtolower($_POST['actionName']).'/s_'.$val['image'].'" class="ui-li-thumb">';
               	 	$str .= '<h3 class="ui-li-heading">'.$val['title'].'</h3>';               
                	$str .= '<p class="ui-li-desc">'.mb_substr(strip_tags(htmlspecialchars_decode($val['content'])),0,100,'utf-8').'</p>';           
            		$str .= '</a></div><span class="ui-icon ui-icon-arrow-r ui-icon-shadow">&nbsp;</span></div></li>';
					
				}else{
					$str .= '<li id="'.$j.'" data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="d" class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-last-child ui-btn-up-d"><div class="ui-btn-inner ui-li"><div class="ui-btn-text">';
					$str .= '<a href="'.__APP__.'/Mobile/'.$_POST['actionName'].'/show/cid/'.$val['category_id'].'/id/'.$val['id'].'.html" class="ui-link-inherit">';
                	$str .= '<h3 class="ui-li-heading">'.$val['title'].'</h3>';               	
                	$str .= '<p class="ui-li-desc">'.mb_substr(strip_tags(htmlspecialchars_decode($val['content'])),0,100,'utf-8').'</p>';               
            		$str .= '</a></div><span class="ui-icon ui-icon-arrow-r ui-icon-shadow">&nbsp;</span></div></li>';
				}
				$j++;	
			}
			
			if($count>C('PAGE_SZIE')){
				$more = 1;
			}else{
				$more = 0;
			}
			if($str==''){ $str ='<li><p>没有相关信息</p></li>'; }
			echo json_encode(array('str'=>$str,'more'=>$more));
	}
}

?>