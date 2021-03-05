<?php
/**
 * 
 * 留言管理控制器
 * @author pc
 *
 */
class GuestbookAction extends AdminAction {
	
	private $model;

	function _initialize() {
		parent::_initialize ();

		$this->setModel('Guestbook');
		$this->assign('c_root', $this->c_root = $_GET['mid']);

	}
	
	public function index() {	

		$rowpage = $_REQUEST['rowpage'];										
		if(empty($_GET['cid'])){
			
			$cid = M('Categorys')->where(array('model_id'=>$_GET['mid'],'fid'=>1))->order('id asc')->limit('0,1')->getField('id');
		}else{
			$cid = $_GET['cid'];
		}		

		$where = $this->pagewhere($cid);
		$this->_dataPage2($where);
			
		$this->assign('cid',$cid);
		$this->display ();
	}
	
	//留言分类
	public function category( $cid ) {
		$_SESSION [C('USER_AUTH_KEY')]['backUrl'] = __APP__.'/Admin/Goods/category';//返回列表连接
		$_GET['pid'] = 21;
		$this->assign('c_root', 21);
		$this->assign('titleText', '分类');
		$this->_category();
	}

	public function add()
	{
		if(!empty($_POST['reply'])){
			$_POST['reply_time'] = time(); //插入回复时间
		}
		$this->_add2($_POST);
	}

	public function update()
	{
		if(!empty($_POST['reply'])){
			$_POST['reply_time'] = time(); //插入回复时间
		}

		$this->_update($_POST);
	}

	public function edit() {
		$this->_edit();
		$this->display ();
	}
	
	public function move()
	{
		$this->_move();
		// $this->display();
	}

	public function deleteById()
	{
		$this->_deleteById();
		// $this->display();
	}

	public function mark_read(){
		$guestbookDao = M('Guestbook');
		$guestbookDao->find($_GET['id']);
		$guestbookDao->read = 1;
		$guestbookDao->save();
		exit;
	}

	public function isPublish() {
		$this->_updateField('is_publish');
	}

	public function delete() {
		if( isset( $_GET['id'] ) ) {
			$this->_deleteById($_GET['id']);
		} else {
			$this->_delete();
		}
	}


	//状态查询
	public function query()
	{
		$rowpage = $_REQUEST['rowpage'];
		$searchKey = $_REQUEST['searchKey'];
		//$where['lang'] = $this->lang;

		if(!empty($_GET['cid'])){
			$cid = addslashes($_GET['cid']);		
			$category_filter = "`category_id` = $cid AND ";
		} else {
			$category_filter = '';
		}
		
		if ($_GET['status'] === 'reply') { //是否已回复
			if($_GET['val'] === '0'){				
				$where['_string'] = " $category_filter  ISNULL(`reply`) OR `reply` = '' ";
			} else if($_GET['val'] === '1') {
				$where['_string'] = " $category_filter !ISNULL(`reply`) AND `reply` != '' ";
			}
		} else if ($_GET['status'] === 'varify'){ //是否已审核
			$val = addslashes($_GET['val']);
			$where['_string'] =  " $category_filter `is_publish` = $val";
		}
				
		// if( !empty($cid) ) {
		// 	$where['category_id'] = $cid;
		// }
		// if( !empty($searchKey) && $searchKey!='请输入关键字' ) {
		// 	$where['_string'] = "title like '%$searchKey%' OR tag like '%$searchKey%'";
		// }
		$rowpage = empty($rowpage)?10:$rowpage;
		$this->assign('dataList', $this->page($where, $rowpage));
		$this->assign('rowpage', $rowpage);
		// $this->assign('searchKey', empty($searchKey)?'请输入关键字':$searchKey);

		$this->display('index');
	}
}
