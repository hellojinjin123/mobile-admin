<?php
/**
 * 
 * 广告管理控制器
 * @author uclnn
 *
 */
class AdvertAction extends AdminAction {
	
	function _initialize() {
		parent::_initialize ();
		$this->setModel('Advert');
		$this->assign('c_root', $this->c_root = $_GET['mid']);
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
	
	public function edit(){
		
		$this->_edit();
		
		$categoryDao = D('Admin.Category');
		$alias = $categoryDao->getAlias( $_GET['cid'] );
		if( $alias=='advert_home_switchover' ) {//跳转到首页图片切换独立编辑页面
			$this->display('edit_switchover');
		} else {
			$this->display ();
		}
	}
	
	public function add(){
		$this->_uploads();
		$this->_add2($_POST);
	}

	public function update(){
		$this->_uploads();
		$this->_update2($_POST);
	}
	
	//添加、更新上传通用
	private function _uploads() {
		$dir = C('UPLOAD_FILE_RULE').'images/advert/';
		$imgwidth = $_POST['imgwidth'];
		$imgheight = $_POST['imgheight'];
		if( !empty($_FILES['image']['name']) && !empty( $imgwidth ) && !empty( $imgheight ) ) {
			$this->_img_upload($dir,'image',true,$imgwidth,$imgheight);
		} elseif( !empty($_FILES['image']['name'] )) {
			$this->_img_upload($dir,'image');
		}
		$image_size = getimagesize($dir.'m_'.$_POST['image']);
		if( !empty($image_size) ) {
			$_POST['width'] = $image_size[0];
			$_POST['height'] = $image_size[1];
		}
		
		if( !empty($_FILES['flash_img1']['name']) || !empty($_FILES['flash_img2']['name']) ) {
			$this->_swf_img_upload($dir);
		}
	}
	
	public function delete(){
		$this->_delete();
	}
	
	public function deleteById(){
		$this->_deleteById();
	}
	
	//删除封面
	public function deleteImage() {
		exit($this->_deleteImage('Public/data/upload/images/advert/'));
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