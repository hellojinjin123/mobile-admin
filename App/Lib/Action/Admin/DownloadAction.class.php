<?php
/**
 *
 * 下载管理控制器
 * @author uclnn
 *
 */
class DownloadAction extends AdminAction {


	function _initialize() {
		parent::_initialize ();
		$this->c_root = 26;
		$this->setModel('Download');
		$this->assign('c_root', $this->c_root=$_GET['mid']);
	}

	public function index() {
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

	public function downloadCategory( $cid ) {
		$_SESSION [C('USER_AUTH_KEY')]['backUrl'] = __APP__.'/Admin/Download/downloadCategory/cid/'.$cid;//返回列表连接

		$categoryDao = D('Admin.Category');
		$c_root = $categoryDao->getId('download_list', $this->lang);

		$_GET['pid'] = 26;
		$this->assign('c_root', 26);
		$this->assign('titleText', '分类');

		$this->_category();
	}

	public function upload(){

		$dir = C('UPLOAD_FILE_RULE').'images/download/';
		$this->_upload2($dir);
	}

	public function edit(){
			
		$this->_edit();
		$this->display ();
	}

	public function add(){
		
		$this->_imgUploads('download');
		$this->_add2($_POST);
	}

	public function update(){
		$this->_deleteFile('Public/data/upload/download/');
		$this->_imgUploads('download');
		$this->_update2($_POST);
	}

	public function delete(){
		$this->_delete();
	}

	public function deleteImage() {
		exit($this->_deleteImage('Public/data/upload/images/download/'));
	}


	public function deleteById(){
		$this->_deleteFile('Public/data/upload/download/');
		$this->_deleteImage('Public/data/upload/images/download/');
		$this->_deleteById();
	}

	public function ordernum(){
		$this->_ordernum();
	}

	public function move(){
		$this->_move();
	}

	public function copy() {
		$this->_copy();
	}

	public function isPublish() {
		$this->_updateField('is_publish');
	}

	public function isHome() {
		$this->_updateField('is_home');
	}

	public function isTop() {
		$this->_updateField('is_top');
	}
}
?>