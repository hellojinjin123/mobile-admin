<?php
/**
 *
 * 视频管理控制器
 * @author uclnn
 *
 */
class VideoAction extends AdminAction {


	function _initialize() {
		parent::_initialize ();
		$this->c_root = 37;
		$this->setModel('Video');
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

	public function videoCategory( $cid ) {
		$_SESSION [C('USER_AUTH_KEY')]['backUrl'] = __APP__.'/Admin/Video/videoCategory/cid/'.$cid;//返回列表连接

		$categoryDao = D('Admin.Category');
		$c_root = $categoryDao->getId('video_list', $this->lang);
		$_GET['pid'] = 37;
		$this->assign('c_root', 37);
		$this->assign('titleText', '分类');
		$this->_category();
	}

	public function upload(){

		//$dir = $this->upload_root_path.'images/video/';
		//$dir = 'Public/data/upload/images/video/';
		$dir = C('UPLOAD_FILE_RULE').'images/video/';
		$this->_upload2($dir);
	}

	public function edit(){
			
		$this->_edit();
		$this->display ();
	}

	public function add(){
		
		$this->_imgUploads('video');
		$_POST['url'] = str_replace('\\','',$_POST['url']);
		$this->_add2($_POST);
	}

	public function update(){
		//$this->_deleteFile($this->upload_root_path.'video/');
		$this->_deleteFile('Public/data/upload/video/');
		$this->_imgUploads('video');
		
		if(!$_POST['is_online'])
		{
			$_POST['is_online'] = 0;
		}
		$_POST['url'] = str_replace('\\','',$_POST['url']);
		$this->_update2($_POST);
	}

	public function delete(){
		$this->_delete();
	}

	public function deleteImage() {
	//	exit($this->_deleteImage($this->upload_root_path.'images/video/'));
	exit($this->_deleteImage('Public/data/upload/images/video/'));
	}


	public function deleteById(){
		//$this->_deleteFile($this->upload_root_path.'video/');
		//$this->_deleteImage($this->upload_root_path.'images/video/');
		$this->_deleteFile('Public/data/upload/video/');
		$this->_deleteImage('Public/data/upload/images/video/');
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
	//改变播放状态
	public function changeShow(){
		$db = M('video');
		$data['is_show'] = 0;
		$sa = $db->where('is_show = 1')->save($data);
			$data2['is_show'] = 1;
			if($sa2 = $db->where('id = '.$_POST['name'])->save($data2))
			{
				echo '1';
			}else
			{
				echo '网络原因导致失败，请重试';
			}
	}
}
?>