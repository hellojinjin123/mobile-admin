<?php
/**
 * 
 * 友情链接管理控制器
 * @author uclnn
 *
 */
class LinkAction extends AdminAction {
	
	function _initialize() {
		parent::_initialize ();
		$this->c_root = 24;
		$this->setModel('Link');
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
	
	public function linkCategory($cid) {
		$_SESSION [C('USER_AUTH_KEY')]['backUrl'] = __APP__.'/Admin/Link/linkCategory/cid/'.$cid;//返回列表连接
		$_GET['pid'] = 24;
		$this->assign('c_root', 24);
		$this->assign('titleText', '分类');
		
		$this->_category();
	}
	
	public function edit(){
		$this->_edit();
		$this->display ();
	}
	
	public function add(){
		$this->_imgUploads('link');
		$this->_add2($_POST);
	}

	public function update(){
		$this->_imgUploads('link');
		$this->_update2($_POST);
	}
	
	public function delete(){
		$this->_delete();
	}
	
	public function deleteById(){
		$this->_deleteById();
	}
	
	//删除封面
	public function deleteImage() {
		exit($this->_deleteImage('Public/data/upload/images/link/'));
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
	
	//手机同步默认语言
	public function synchMobile() {
		$this->_synchMobile();
	}
}
?>