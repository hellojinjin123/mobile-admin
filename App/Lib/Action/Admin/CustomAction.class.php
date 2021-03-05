<?php
/**
 *
 * 系统定制（生成系统使用，上传网站到正式空间前请删除）
 * @author uclnn
 *
 */
class CustomAction extends AdminAction {

	function _initialize() {
		parent::_initialize ();
	}
	
	//生成系统
	public function generateSystem() {
		$data['begin_time'] = strtotime($_POST['begin_time']);
		$data['end_time'] = strtotime($_POST['end_time']);
		$data['space_mb'] = $_POST['space_mb'];
		$customDao = M('Custom');
		$customDao->where( array('id'=>1) )->save($data);
		echo "<script language=\"javascript\">alert('嘻嘻/哈哈！');window.top.location.href='".__APP__."/Admin/Index/index';</script>";
	}

	public function index() {
		//读取自定义栏目
		$partDao = M('Part');
		$part = $partDao->where(array('lang'=>'zh-cn','pid'=>0))->order('orderNum desc')->select();
		for($i=0 ;$i<count($part) ;$i++ ){
			$getNext = $partDao->where(array('lang'=>'zh-cn','pid'=>$part[$i]['id']))->order('orderNum desc')->select();
			$part[$i]['next'] = $getNext;
		}
		$customDao = M('Custom');
		$custom = $customDao->find(1);
		$this->assign('part',$part);
		$this->assign('custom', $custom);
		$this->display ();
	}

	public function updateLang(){
		$this->setModel('Category');
		$data = $_POST;
		$data['id'] = $_POST['lang_id'];
		$this->_update($data);
	}

	public function addLang(){
		$this->setModel('Category');
		$this->_add($_POST);
	}

	//设置默认语言
	public function defaultLang(){
		$lang_id = $_GET['lang_id'];
		$categoryDao = M('Category');
		$alias = $categoryDao->getField('alias',array('id'=>$lang_id));
		$customDao = M('Custom');
		$customDao->setField('def_lang', $alias);
		exit();
	}

	//语言下拉
	public function selectOptionLang() {
		$pid = $_REQUEST['pid'];
		$categoryDao = M('Category');
		$customDao = M('Custom');
		$dataList = $categoryDao->where(array('pid'=>$pid))->order('ordernum desc')->select();
		$def_lang = $customDao->getField('def_lang',array('id'=>1));
		$options = '<option value="" selected>请选择</option>';
		foreach ($dataList as $key => $value) {
			$style = '';
			if( $value['alias']==$def_lang ) {
				$style = 'style="color:red"';
			}
			$options .= '<option value="'.$value['id'].'" '.$style.'>'.$value['title'].'</option>';
		}
		exit($options);
	}

	//更改选择的语言
	function updateLangs() {
		$langs = $_GET['langs'];
		$customDao = M('Custom');
		$customDao->setField('langs', implode(',', $langs), array('id'=>1));
		exit();
	}
	
	
	//栏目操作**********************************************************************
	
	//添加栏目
	public function addColumn(){
		$this->setModel('Category');
		$data = $_POST;
		//$levels = $_POST['one_category'];
		
		$categoryDao = D('Admin.Category');
		$data['levels'] = $categoryDao->getUpLevels($_POST['pid']).'|'.$_POST['pid'];

// 		if( empty($_POST['my_id']) ) {
// 			if( !empty($_POST['two_category']) ) {
// 				$levels.='|'.$_POST['two_category'];
// 			}
// 			if( !empty($_POST['three_category']) ) {
// 				$levels.='|'.$_POST['three_category'];
// 			}
// 			$data['levels'] = $levels;
// 		}
		
		$this->_add($data);
	}
	//添加自定义栏目名称功能
	public function addColumnPart(){
		$partDao = M('Part');
		$result = $partDao->add($_POST);
		if($result){
			echo '1';
		}else{
			echo '0';
		}
	}
	//修改自定义栏目名称
	public function editPart(){
		if(!$_POST['is_publish']){
			$_POST['is_publish'] = 0;
		}
		$partDao = M('Part');
		$checkId = $partDao->where('id = '.$_POST['id'])->find();
		if(!$checkId){
			echo '3'; 
		}else{
			$result = $partDao->where('id = '.$_POST['id'])->data($_POST)->save();
			if($result){
				echo '1';
			}else{
				echo '2';
			}
		}
		//dump($_POST);
	}
	//某个自定义栏目信息
	public function partInfo(){
		$partDao = M('Part');
		$result = $partDao->where('id = '.$_POST['id'])->find();
		//dump($result);
		echo json_encode($result);
		//dump($result);		
	}
	//栏目下拉
	public function selectOptionColumn() {
		$pid = $_REQUEST['pid'];
		if(!empty($pid)){
			$categoryDao = M('Category');
			$dataList = $categoryDao->where( array('pid'=>$pid, 'lang'=>$this->custom['def_lang'], 'is_fixed'=>0) )->order('ordernum desc')->select();
			$options = '<option value="" selected>请选择</option>';
			foreach ($dataList as $key => $value) {
				$options .= '<option value="'.$value['id'].'">'.$value['title'].'</option>';
			}
			exit($options);
		}
	}
	
	//修改分类
	public function updateColumn(){
		$this->setModel('Category');
		$data = $_POST;
		$this->_update($data);
	}
	
	//删除分类
	public function deleteCategory() {
		$id = $_REQUEST ['id'];
		if (! empty ( $id )) {
			$categoryDao = M ( 'Category' );
			
			$count = $categoryDao->where ( array('is_delete'=>0,'id'=>$id) )->count ();
			if( $count > 0 ) {// 系统默认不能删除
				exit('on_delete');
			}
			
			$count = $categoryDao->where ( array('pid'=>$id) )->count ();
			if ($count > 0) { //存在子分类不能删除
				exit('sub_exist');
			} else {
				$where['is_delete'] = 1;
				$where['_string'] = 'my_id='.$id.' or id='.$id;
				$result = $categoryDao->where($where)->delete();
				if( $result!==false ) {
					exit('true');
				} else {
					exit('false');
				}
			}
		}
	}
	
	//获取不同语言分类
	public function getCategoryByLang() {
		$categoryDao = M('Category');
		$my_id = $categoryDao->where(array('id'=>$_GET['id']))->getField('my_id');
		$category = $categoryDao->where(array('my_id'=>$my_id,'lang'=>$_GET['lang']))->find();
		exit(json_encode($category));
	}

	//模块操作***************************************************************
	
	//选择的模块
	function selectModule() {
		$pid = $_GET ["pid"];
		$category = M ( "Category" );
		$categoryList = $category->where ( array('pid'=>$pid,'lang'=>$this->lang) )->order('ordernum desc')->select ();
		$json ['list'] = $categoryList;
		exit(json_encode ( $json ));
	}

	//更改选择的模块
	function updateModules() {
		$modules = $_GET['modules'];
		$customDao = M('Custom');
		$categoryDao = M('Category');
		$customDao->setField('modules', implode(',', $modules), array('id'=>1));
		foreach ($modules as $key => $value) {
			$data[$key]['id'] = $value;
			$data[$key]['title'] = $categoryDao->getField('title', array('id'=>$value));
		}
		exit(json_encode( $data ) );
	}
	
	//设置手机显示分类
	function updateIsMobile() {
	    $id = $_GET['id'];
	    $is_checked = $_GET['is_checked'];
	    $is_mobile = $is_checked=='true'?'1':'0';
	    $categoryDao = M('Category');
	    $result = $categoryDao->setField('is_mobile', $is_mobile, array('id'=>$id));
	    exit(json_encode(array('bool'=>$result,'id'=>$id,'is_checked'=>$is_checked,'is_mobile'=>$is_mobile)));
	}
	
	//重置数据
	function clearUserData() {
		//删除用户添加的分类
		$categoryDao = M('Category');
		$categoryDao->where(array('is_delete'=>1))->delete();
		$categoryDao->where(array('is_delete'=>0))->setField('list_count',0);
		
		//清空表数据
		$model = new Model();
		$sqls = array('news','goods','goods_inquire','goods_photo','advert','comment','download','guestbook','job','joinin','link','market','member','mobile_website','survey','survey_answer','survey_question','survey_result','system');
		foreach ($sqls as $key => $value) {
			$model->execute('TRUNCATE TABLE '.C('DB_PREFIX').$value);
		}
		
	}
	public function partList(){
		$partDao = M('Part');
		//$result = $partDao->where(array('lang' => $_POST['lang'],'is_publish' => 1))->order('orderNum desc')->select();
		$result = $partDao->where(array('lang' => $_POST['lang'],'pid' => 0))->order('orderNum desc')->select();
		for($i=0 ;$i<count($result) ;$i++ ){
			$getNext = $partDao->where(array('lang'=>$_POST['lang'],'pid'=>$result[$i]['id']))->order('orderNum desc')->select();
			$result[$i]['next'] = $getNext;
		}
		if($result)
		{
			echo json_encode($result);
		}else{
			echo '0';
		}
	}
	public function deleteList(){
		$partDao = M('Part');
		$result = $partDao->where(array('id' => $_POST['id']))->delete();
		if($result)
		{
			echo '1';
			//echo json_encode($result);
		}else{
			echo '0';
		}
	}
	public function _partF(){
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
}
?>