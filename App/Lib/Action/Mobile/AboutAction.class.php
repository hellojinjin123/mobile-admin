<?php
class AboutAction extends MobileAction{
	
	function _initialize() {
		parent::_initialize();
	}
	
	function index(){
		
		$obj = M('News')->where('category_id=110')->find();
		$this->assign('obj',$obj);
		$this->display();
	}
	
}

?>