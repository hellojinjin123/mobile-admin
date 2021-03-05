<?php
//多语言表单元素radio,checkbox（系统定制使用,需要迁移）
function langInput( $type ) {
	$customDao = D('Custom');
	$categoryDao = D('Category');
	$def_lang = $customDao->getField('def_lang',array('id'=>1));
	$langList = $categoryDao->where(array('pid'=>11))->order('ordernum desc')->select();
	if( !empty($langList) ) {
		foreach ($langList as $key => $value) {
			if($value['alias'] == $def_lang ) {
				$style = 'style="color:red;"';
			} else {
				$style = '';
			}
			$input .= '<input type="'.$type.'" id="langs" name="langs" value="'.$value['alias'].'"> <span '.$style.'>'.$value['title'].'</span>&nbsp;&nbsp';
		}
	}
	echo $input;
}

//是否使用多语言
function isLang($isRemoveMobile=true) {
	$customDao = D('Custom');
	$categoryDao = D('Category');
	$custom = $customDao->find(1);
	$def_lang = $custom['def_lang'];
	if( $isRemoveMobile==true ) {
		$langs = str_replace('mobile,', '', $custom['langs']);
	} else {
		$langs = $custom['langs'];
	}
	$langList = $categoryDao->where(array('alias'=>array('in',$langs)))->order('ordernum desc')->select();
	if( count($langList)>1 ) {
		foreach ($langList as $key => $value) {
			if($value['alias'] == $def_lang ) {
				$style = 'style="color:red;"';
				$checked = 'checked';
			} else {
				$style = '';
				$checked = '';
			}
			$input .= '<input type="radio" id="lang" name="lang" value="'.$value['alias'].'" '.$checked.'> <span '.$style.'>'.$value['title'].'</span>&nbsp;&nbsp;';
		}
		$li = '<label>选择语言<a href="#" class="issue" title="如果有两种语言以上,请先添加默认语言再切换到其它语言添加">?</a></label>'.$input;
	} else {
		$li .= '<input type="hidden" name="lang" value="'.$def_lang.'">';
	}
	echo $li;
}
//按语言查找
function isLang2() {
	$customDao = D('Custom');
	$categoryDao = D('Category');
	$custom = $customDao->find(1);
	$def_lang = $custom['def_lang'];
	if( $isRemoveMobile==true ) {
		$langs = str_replace('mobile,', '', $custom['langs']);
	} else {
		$langs = $custom['langs'];
	}
	$langList = $categoryDao->where(array('alias'=>array('in',$langs)))->order('ordernum desc')->select();
	if( count($langList)>1 ) {
		foreach ($langList as $key => $value) {
			if($value['alias'] == $def_lang ) {
				$style = 'style="color:red;"';
				$checked = 'checked';
			} else {
				$style = '';
				$checked = '';
			}
			$input .= '<input type="radio" name="lang111" value="'.$value['alias'].'" '.$checked.'> <span '.$style.'>'.$value['title'].'</span>&nbsp;&nbsp;';
		}
		$li .=$input;
	} else {
		$li .= '<input type="hidden" name="lang" value="'.$def_lang.'">';
	}
	echo $li;
}

//能否评论
function isComment($is_comment) {
	if( $is_comment==0 ) {
		$style = 'style="display:none;"';
	}
	$li = '<li id="li_is_comment" '.$style.'><label>能否评论?</label><input type="radio" id="is_comment" name="is_comment" value="1"> 是&nbsp;&nbsp;<input type="radio" id="is_comment" name="is_comment" value="0" checked="checked"> 否</li>';
	echo $li;
}

function getUserAccess($id){
	$useraccess = M('User_access')->where('uid='.$id)->getField('access');
	
	$useraccess = json_decode($useraccess,true);
	
	if($useraccess){
		$model = M('Categorys');
		$Modelconfig = M('Modelconfig')->select();
		foreach($Modelconfig as $val){ $mod[$val['modelaction']] = $val['modelname']; }
		foreach($useraccess as $key=>$value){
			$res .= $mod[$key].'：';
			unset($value[0]);
			if($value){			
				//$res .= ':';
				$str ='';
				foreach($value as $vid){
					$obj = $model->where('id='.$vid)->find();					
					if(in_array($obj['fid'],$value)){
						$str .= '-->'.$obj['title'];
					}else{
						if($obj['fid']==1){
							$str .= '<br>&nbsp;&nbsp;|-->'.$obj['title'];
						}						
					}					
				}
				$res .= $str;
			}
			$res .= '<br>';
		}
		echo $res;
	}
}

//是否多语言
function isMultilingual($custom) {
	$langs = explode(',', str_replace('mobile,', '', $custom['langs']));
	if( count($langs) >= 2 ) {
		return true;
	} else {
		return false;
	}
}

function getAdverCatelist($mid){
	
	$cate_id = M('Categorys')->where('fid=1 and model_id='.$mid)->limit(1)->getField('id');
	return M('Categorys')->where('fid='.$cate_id)->order('id asc')->select();
}

function Categorylist($fid,$mid){
	

	return M('Categorys')->where('fid='.$fid.' and model_id='.$mid)->order('id asc')->select();
	
}

function getMenuUrl($obj){
	if(!empty($obj['funname'])){
		echo $obj['funname'].'/mid/'.$obj['model_id'].'/cid/'.$obj['id'];
	}else{
		echo "index/mid/".$obj['model_id']."/cid/".$obj['id'];
	}
}

function getCateList($cid,$mid){
	
		//显示分类处理
		$categoryDao = M('Categorys');	
		if(empty($mid)){	
			$category = $categoryDao->where('id='.$cid)->find();
			$where['model_id'] = $category['model_id'];
		}else{
			$where['model_id'] = $mid;
		}
		$where['fid']=1;
		
		$where['tpl_one'] = array('neq','one');
		$onecategory = $categoryDao->where($where)->order('id asc')->select();
		$str  = '<select id="one_category_id" name="one_category_id" style="width:200px;" onchange="changeCategory(this,\'two_category_id\')">';
		$str .= '<option value="" >请选择</option>';	
		foreach($onecategory as $val){			
	        $str .= '<option value="'.$val['id'].'" ';
	        if($val['id']==substr($cid,0,3)){
	        	$str .= 'selected="selected"';
	        	$select_id = $val['id'];
	        }
	        $str .= '>'.$val['title'].'</option>';	  
		}
		$str .= '</select>';
		$where2['fid']=$select_id;		
		$where2['tpl_one'] = array('neq','one');
		$twocate = $categoryDao->where($where2)->order('id asc')->select();
		
			$str .= '<select id="two_category_id" name="two_category_id" style="width:200px;" onchange="changeCategory(this,\'three_category_id\')">';
			$str .= '<option value="" >请选择</option>';	
			if($twocate){	
				foreach($twocate as $val){			
			        $str .= '<option value="'.$val['id'].'" ';
			        if($val['id']==substr($cid,0,5)){
			        	$str .= 'selected="selected"';
			        	$select_id2 = $val['id'];
			        }
			        $str .= '>'.$val['title'].'</option>';	  
				}
			}
			$str .= '</select>';
			$where3['fid']=$select_id2;		
			$where3['tpl_one'] = array('neq','one');
			$threecate = $categoryDao->where($where3)->order('id asc')->select();
			
			$str .= '<select id="three_category_id" name="three_category_id" style="width:200px;" onchange="changeCategory(this,\'\')">';
			$str .= '<option value="" >请选择</option>';	
				if($threecate){	
					foreach($threecate as $val){			
				        $str .= '<option value="'.$val['id'].'" ';
				        if($val['id']==$cid){
				        	$str .= 'selected="selected"';
				        	
				        }
				        $str .= '>'.$val['title'].'</option>';	  
					}
				}
			$str .= '</select>';
			
		
		
		echo $str;
}

//返回分类标题
function getCategoryTitle($id) {
	
	echo M('Categorys')->getField('title', array('id'=>$id));
	
}

//显示状态
function getShowState($is_publish,$is_home,$is_top,$is_comment){
	if($is_publish==1) echo '发布 ';
	if($is_home==1) echo '首页 ';
	if($is_top==1) echo '置顶 ';
	if($is_comment==1) echo '评论 ';
}

//获取广告类型文字说明
function getAdvertTypeText( $type ) {
	if( $type==1 ) {
		echo '文字';
	} elseif ( $type==2 ) {
		echo '图片';
	} elseif ( $type==3 ) {
		echo 'flash';
	} elseif ( $type==4 ) {
		echo '代码';
	} elseif ( $type==5 ) {
		echo '对联';
	}
}

//输出语言标题
function getLangText( $alias ) {
	$customDao = D('Custom');
	$categoryDao = M('Category');
	$langs = explode(',', $customDao->getField('langs', array('id'=>1)));
	if( count($langs) >1 ) {
		$title = $categoryDao->getField('title', array('alias'=>$alias));
		echo '['.substr($title, 0, 3).']';
	}
}

//checkbox状态
function getCheckboxState($vo_id,$name,$state){
	if($state==1) {
		echo '<input type="checkbox" checked="checked" value="'.$vo_id.'" name="'.$name.'" id="'.$name.'" />';
	} else {
		echo '<input type="checkbox" value="'.$vo_id.'" name="'.$name.'" id="'.$name.'" />';
	}
}

//是否有分类
function isCategory( $oneC, $twoC, $threeC, $lable='分类', $lang='') {
	//一级分类
	if( empty($oneC) ) {
		$oneHide = 'display:none;';
	}
	if( $lang=='mobile' ) {
		$c_lang = 'mobile_';
	}
	$li = '<li id="li_'.$c_lang.'category" style="'.$oneHide.'"><label>'.$lable.'</label>';
	$li .= '<select id="one_'.$c_lang.'category_id" name="one_'.$c_lang.'category_id" style="width:200px;" onchange="changeCategory(this,\'two_'.$c_lang.'category_id\',\''.$lang.'\')">';
	$li .= '<option value="-1" selected="">请选择</option>';
	foreach ($oneC as $key => $value) {
		$li .= '<option value="'.$value['my_id'].'">'.$value['title'].'</option>';
	}
	$li .= '</select> ';

	//二级分类
	if( empty($twoC) ) {
		$twoHide = 'display:none;';
	}
	$li .= '<select id="two_'.$c_lang.'category_id" name="two_'.$c_lang.'category_id" style="width:200px;'.$twoHide.'" onchange="changeCategory(this,\'three_'.$c_lang.'category_id\',\''.$lang.'\')">';
	$li .= '<option value="-1" selected="">请选择</option>';
	foreach ($twoC as $key => $value) {
		$li .= '<option value="'.$value['my_id'].'">'.$value['title'].'</option>';
	}
	$li .= '</select> ';

	//三级分类
	if( empty($threeC) ) {
		$threeHide = 'display:none;';
	}
	$li .= '<select id="three_'.$c_lang.'category_id" name="three_'.$c_lang.'category_id" style="width:200px;'.$threeHide.'" onchange="changeCategory(this,\'\',\''.$lang.'\')">';
	$li .= '<option value="-1" selected="">请选择</option>';
	foreach ($threeC as $key => $value) {
		$li .= '<option value="'.$value['my_id'].'">'.$value['title'].'</option>';
	}
	$li .= '</select></li>';

	echo $li;
}

//分类组装下拉选择
function selectCateoryOptions($pidOrAlias) {
	$cateoryDao = M ( 'Categorys' );
	if( !is_numeric($pidOrAlias) ) {
		$where['pid'] = $cateoryDao->getField('id', array('alias'=>$pidOrAlias));
	} else {
		$where['pid'] = $pidOrAlias;
	}
	$where['lang'] = $lang;
	$where['is_fixed'] = 0;
	$cateory = $cateoryDao->where ( $where )->select ();
	foreach ( $cateory as $val ) {
		$options .= '<option value="' . $val ['id'] . '">' . $val ['title'] . '</option>';
	}
	echo $options;
}

//通过别名获取分类ID
function getCategoryIdByAlias($alias) {
	$cateoryDao = M ( 'Category' );
	return $cateoryDao->getField('id', array('alias'=>$alias));
}

//获取当前招聘简历个数
function getJobResumeCount($job_id) {
	$jrDao = M('JobResume');
	echo $jrDao->where(array('job_id'=>$job_id))->count();
}

//招聘简历列表
function findJobResume($job_id) {
	$jrDao = M('JobResume');
	$jrList = $jrDao->where(array('job_id'=>$job_id))->select();
	foreach ($jrList as $key => $value) {
		$tr .= '<tr>';
		$tr .= "<td>".$value['linkname']."</td>";
		$tr .= "<td>".$value['sex']."</td>";
		$tr .= "<td>".$value['age']."</td>";
		$tr .= "<td>".$value['phone']."</td>";
		$tr .= "<td>".$value['address']."</td>";
		$tr .= "<td>".$value['email']."</td>";
		$tr .= "<td>".$value['intro']."</td>";
		if( !empty($value['file']) ) {
			$tr .= '<td><a href="'.__PUBLIC__.'/data/upload/files/resume/'.$value['file'].'">查看简历文件</a></td>';
		} else {
			$tr .= "<td>没有上传</td>";
		}
		$tr .= "<td>".date('Y-m-d',$value['create_time'])."</td>";
		$tr .= '<td><a href="#" onclick="javascript:deleteData(\''.__APP__.'/Admin/Job/deleteResume/id/'.$value['id'].'\');">删除</a></td>';
		$tr .= '</tr>';
	}
	echo $tr;
}

//找出父级的子分类
function selectCategoryByPid( $pid ) {
	$categoryDao = M ( "Category" );
	return $categoryDao->where ( array('pid'=>$pid) )->order('ordernum desc')->select ();
}

function get_GoodsPhotos($goods_id){
	$jrDao = M('GoodsPhoto');
	return $jrDao->where(array('goods_id'=>$goods_id))->select();
}

function get_SurveyQues($survey_id){
	$jrDao = M('SurveyQuestion');

	return $jrDao->where(array("sort_id"=>$survey_id))->order('id asc')->select();
}

function get_surveyAnswer($qid){
	$jrDao = M('SurveyAnswer');
	return $jrDao->where(array('ques_id'=>$qid))->order('ordernum asc')->select();
}

function get_SureyResult($id,$antype){
	$jrDao = M('SurveyResult');
	if($antype!=3){
		return $jrDao->where(array('answer_id'=>$id))->order('id DESC')->count();
	}else{
		return $jrDao->where(array('ques_id'=>$id))->order('id DESC')->select();
	}
}

function get_QuesListEdit($sortid){

	$queslist = get_SurveyQues($sortid);
	if($queslist){
		$questr = '';
		foreach($queslist as $key=>$ques){
			$ques_id .= $ques['id'].',';
			$questr .= "<span id='questit".($key+1)."'>";
			$questr .= "<label></label><span>".($key+1).". <input id='ques_title".($key+1)."' name='ques_title[]' value='".$ques['ques_title']."' class='type-text'/></span><img src='__ADMIN__/Public/imgs/cross.png' title='删除问题' onclick='del_ques(".($key+1).",".$ques['id'].")'/><br>";
			$questr .= "<input type='hidden' id='ques_id".($key+1)."' name='ques_id[]' value='".$ques['id']."'/>";
			$radiochk1 = ($ques['answer_type'] ==1)?'checked':'';
			$radiochk2 = ($ques['answer_type'] ==2)?'checked':'';
			$radiochk3 = ($ques['answer_type'] ==3)?'checked':'';
			if($ques['answer_type']!=3){
				$questr .= "<label></label><input type='radio' id='answer_type1".($key+1)."' name='answer_type".($key+1)."' value='1' ".$radiochk1." >答案单选";
				$questr .= "<label></label><input type='radio' id='answer_type2".($key+1)."' name='answer_type".($key+1)."' value='2' ".$radiochk2." >答案多选";
				$questr .= "<label></label><input type='radio' id='answer_type3".($key+1)."' name='answer_type".($key+1)."' value='3' ".$radiochk3." >答案输入<br>";
				$answerlist = get_surveyAnswer($ques['id']);
				if($answerlist){
					foreach($answerlist as $k=>$val){
						$questr .= "<label></label><input type='hidden' id='orderid".($k+1).($key+1)."' name='orderid".($key+1)."[]'  value='".$val['ordernum']."'>";
						$questr .= "<input id='answer_title".($k+1).($key+1)."' name='answer_title".($key+1)."[]' value='".$val['answer_title']."' size='40'><br>"	;
						$questr .= "<input type='hidden' id='answer_id".($k+1).($key+1)."' name='answer_id".($key+1)."[]' value='".$val['id']."' size='40'><br>"	;
					}
				}
			}else{
				$questr .= "<label></label><input type='radio' id='answer_type1".($key+1)."' name='answer_type".($key+1)."' value='1' ".$radiochk1." onclick='add_answer(1,".($key+1).")'>答案单选";
				$questr .= "<label></label><input type='radio' id='answer_type2".($key+1)."' name='answer_type".($key+1)."' value='2' ".$radiochk2." onclick='add_answer(2,".($key+1).")'>答案多选";
				$questr .= "<label></label><input type='radio' id='answer_type3".($key+1)."' name='answer_type".($key+1)."' value='3' ".$radiochk3." onclick='add_answer(3,".($key+1).")'>答案输入<br>";
				$questr .= "<label></label><span id='ques".($key+1)."' style='display:none'></span><br>";
			}
			$questr .= "</span>";
		}
	}
	echo $questr;
}

function get_QuesResultList($sortid){

	$queslist = get_SurveyQues($sortid);
	if($queslist){
		$questr = '';
		foreach($queslist as $key=>$ques){
			$ques_id .= $ques['id'].',';
			$questr .= "<span >";
			$questr .= "<label></label><span>".($key+1).". ".$ques['ques_title']."</span><br>";

			if($ques['answer_type']!=3){
				$answerlist = get_surveyAnswer($ques['id']);
				$answer = array('A','B','C','D');
				foreach($answerlist as $k=>$val){
					$count = get_SureyResult($val['id'],$val['answer_type']);
					$questr .= "<label></label>&nbsp;&nbsp;&nbsp;&nbsp;".$answer[$k].'. '.$val['answer_title']."&nbsp;&nbsp;&nbsp;&nbsp; 投票次数：".$count."<br>"	;
				}
			}else{
				$textAnswer = get_SureyResult($ques['id'],$ques['answer_type']);
				if($textAnswer){
					foreach($textAnswer as $key=>$value){
						$questr .= "<label></label>&nbsp;&nbsp;&nbsp;&nbsp;(".($key+1)."). ".$value['answer_text']."<br>"	;
					}
				}
			}
			$questr .= "</span><br><br>";
		}
	}
	echo $questr;

}

function getslaveCate($fid){
	$model = M('Categorys');
	$catedata = $model->where(array('fid'=>$fid))->order('id asc')->select();
	$str = '';
	if($catedata){
		foreach($catedata as $value){
			$str .='<tr>';
		    $str .='<td><input type="checkbox" name="ids[]" id="ids'.$value['id'].'" value="'.$value['id'].'"></td>';
		    $str .='<td>&nbsp;&nbsp;|---<strong>'.$value['title'].'</strong></td>';		     		    
			$str .='<!--  <td align="center"></td>-->';
		    $str .='<td align="right">';
		    $str .='[<a href="__APP__/Admin/Category/edit/act/addsubclass/mid/'.$value['model_id'].'/id/'.$value['id'].'">添加子分类</a>] &nbsp; ';
		    $str .='[<a href="__APP__/Admin/Category/edit/act/update/mid/'.$value['model_id'].'/id/'.$value['id'].'">编辑</a>] &nbsp;';
		    $str .='[<a href="#" onclick="godelUrl(\'__APP__/Admin/Category/delete/mid/'.$value['model_id'].'/id/'.$value['id'].'\');">删除</a>] </td>';
		    $str .='</tr>';
			
		    $catedata2 = $model->where(array('fid'=>$value['id']))->order('id asc')->select();
		    foreach($catedata2 as $val){
			    $str .='<tr>';
			    $str .='<td><input type="checkbox" name="ids[]" id="ids'.$val['id'].'" value="'.$val['id'].'"></td>';
			    $str .='<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|----<strong>'.$val['title'].'</strong></td>';			      			    
				$str .='<!--  <td align="center"></td>-->';
			    $str .='<td align="right">';
			    //$str .='[<a href="__APP__/Admin/Category/edit/act/addsubclass/mid/'.$val['model_id'].'/id/'.$val['id'].'">添加子分类</a>] &nbsp; ';
			    $str .='[<a href="__APP__/Admin/Category/edit/act/update/mid/'.$val['model_id'].'/id/'.$val['id'].'">编辑</a>] &nbsp;';
			    $str .='[<a href="#" onclick="godelUrl(\'__APP__/Admin/Category/delete/mid/'.$val['model_id'].'/id/'.$val['id'].'\');">删除</a>] </td>';
			    $str .='</tr>';
			    
			    $catedata3 = $model->where(array('fid'=>$val['id']))->order('id asc')->select();
			    foreach($catedata3 as $v){
			    	$str .='<tr>';
				    $str .='<td><input type="checkbox" name="ids[]" id="ids'.$v['id'].'" value="'.$v['id'].'"></td>';
				    $str .='<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|--<strong>'.$v['title'].'</strong></td>';				      				   				    
					$str .='<!--  <td align="center"></td>-->';
				    $str .='<td align="right">';
				   // $str .='[<a href="__APP__/Admin/Category/edit/act/addsubclass/m_id/'.$val['model_id'].'/id/'.$val['id'].'">添加子分类</a>] &nbsp; ';
				    $str .='[<a href="__APP__/Admin/Category/edit/act/update/mid/'.$v['model_id'].'/id/'.$v['id'].'">编辑</a>] &nbsp;';
				    $str .='[<a href="#" onclick="godelUrl(\'__APP__/Admin/Category/delete/mid/'.$v['model_id'].'/id/'.$v['id'].'\');">删除</a>] </td>';
				    $str .='</tr>';
			    	
			    }
			    
		    }
		}
		
	}
	echo $str;
}

function getCate($id){
	
	$categoryDao = M('Categorys');
	$category = $categoryDao->where('fid='.$id)->order('id asc')->select();
	return $category;
}

//显示页面当前位置导航
function getNavSite($mid,$cid) {
			
	if(!empty($cid)){
		
		$model = M('Categorys');
		$onecate = $model->where('id='.$cid)->find();
		
		$modelname = M('Modelconfig')->where('id='.$onecate['model_id'])->getField('modelname');
		if($onecate['fid']==1){
			$category = ' > '.$onecate['title'];
		}else{			
			$category = ' > '.$onecate['title'];
			$twocate = getFamilyCate($onecate['fid']);
						
		}
		echo '> '.$modelname.$twocate.$category;
	}else{
		$modelname = M('Modelconfig')->where('id='.$mid)->getField('modelname');
		echo '> '.$modelname;
	}	

	
}

function getFamilyCate($fid){
	$model = M('Categorys');
	$res = $model->where('id='.$fid)->find();
	if($res['fid']==1){
		$str = ' > '.$res['title'];
	}else{
		
		$res2 = $model->where('id='.$res['fid'])->find();
		
		$str = ' > '.$res2['title'];
		$str .= ' > '.$res['title'];
		
	}
	return $str;
}


//获取左边菜单URL
function getSideMenuUrl($p_alias,$my_id) {
	
	echo __APP__.'/Admin/'.$p_alias.'/index/cid/'.$my_id;
	
}

function getAction($mid){

	echo M('Modelconfig')->where('id='.$mid)->getField('modelaction');
}

function getslaveColumn($fid){
	return M('Categorys')->where('fid='.$fid)->select();
}

//如果URL参数带lang优先返回
function getAddButtonLang($get_Lang, $lang) {
	if( !empty($get_Lang) ) {
		echo $get_Lang;
	} else {
		echo $lang;
	}
}

//获取手机同步按钮
function getSynchMobileButton($custom,$vo) {
	if($custom['def_lang']==$vo['lang']) {
		echo '<input type="button" value="同步" onclick="synchMobile('.$vo['id'].');">';
	}
}

//是否有手机网站
function isShowMobile($custom, $lang ) {
	if(empty($lang) && substr_count($custom['langs'],'mobile')==1) {
		return true;
	} else if(substr_count($custom['langs'],'mobile')==1) {
		if( $custom['def_lang']==$lang ) {
			return true;
		} else {
			return true;
		}
	} else {
		return false;
	}
}

// 单位自动转换函数
function getRealSize($size) {
	$kb = 1024; // Kilobyte
	$mb = 1024 * $kb; // Megabyte
	$gb = 1024 * $mb; // Gigabyte
	$tb = 1024 * $gb; // Terabyte

	if ($size < $kb) {
		return $size . " B";
	} else if ($size < $mb) {
		return round ( $size / $kb, 2 ) . " KB";
	} else if ($size < $gb) {
		return round ( $size / $mb, 2 ) . " MB";
	} else if ($size < $tb) {
		return round ( $size / $gb, 2 ) . " GB";
	} else {
		return round ( $size / $tb, 2 ) . " TB";
	}
}
//radio 状态
function getRadioState($vo_id,$name,$state)
	{
		if($state == 1)
		{
			echo '<input type="radio" value="'.$vo_id.'" name="'.$name.'" id="'.$name.'"  checked="checked"/>';
		}else
		{
			echo '<input type="radio" value="'.$vo_id.'" name="'.$name.'" id="'.$name.'" />';
		}
	}
//获取顶级栏目
function _partF(){
	$lang = $_POST['lang'];
	if(!$lang){ $lang = 'zh-cn';}
	$db = M('Part');
	$result = $db->where(array('pid' => 0 , 'lang' => $lang ))->select();
	foreach($result as $key => $value){
		    $title	.='<option value="'.$value['id'].'">'.$value['title'].'</option>';
		}
	echo '<option value="0">请选择</option>'.$title;
	//dump($result);
	}