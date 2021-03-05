<?php
/**
 * 
 * 网络营销管理控制器
 * @author uclnn
 *
 */
class MarketAction extends AdminAction {
	
	function _initialize() {
		
		parent::_initialize ();
		$this->c_root = 22;
		$this->setModel('Market');
		$this->assign ( 'leftArea', 'Inc:sidemenu' );
		$this->assign('c_root', $this->c_root);
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
	
	//区域管理
	public function marketArea( $cid ) {
		$_SESSION [C('USER_AUTH_KEY')]['backUrl'] = __APP__.'/Admin/Market/marketArea/cid/'.$cid;//返回列表连接
		$_GET['pid'] = 469;
		$this->assign('c_root', 469);
		$this->assign('titleText', '区域');
		$where['is_fixed'] = 1;
		$this->_category($where);
	}
	
	public function edit(){
		$this->_edit();
		if($_GET['lang']=='mobile') {
			$this->display ('edit_mobile');
		} else {
			$this->display ();
		}
	}
	
	//单页添加
	public function saveOne() {
		$this->_imgUploads('market');
		$this->_saveOne($_POST);
	}
	
	public function add(){
		$this->_imgUploads('market');
		$this->_add2($_POST);
	}

	public function update(){
		$this->_imgUploads('market');
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
		exit($this->_deleteImage('Public/data/upload/images/market/'));
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