<?php
class MessageAction extends MobileAction{
	
	function _initialize() {
		parent::_initialize();
		$this->setModel('Guestbook');
	}

	function index(){
		
		$this->display();
	}
	
	function save(){
		
		if($_SESSION['verify'] != md5($_POST['verify'])) {
			echo json_encode(array('msg'=>'-1'));
			exit;
		}
		
		$_POST['category_id'] = '150';
		$_POST['create_time'] = time();
		if($this->modelDao->add($_POST)){
			
			echo json_encode(array('msg'=>'1'));
			exit;
		}else{
			echo json_encode(array('msg'=>'-2'));
			exit;
		}
		
	}
	
	//验证码
	public function verify() {
		$type = isset ( $_GET ['type'] ) ? $_GET ['type'] : 'gif';
		import ( "ORG.Util.Image" );
		Image::buildImageVerify ( 4, 1, $type );
	}
}

?>