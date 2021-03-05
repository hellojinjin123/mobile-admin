<?php
class ContactAction extends  MobileAction{
	
	function _initialize() {
		parent::_initialize();
		$this->setModel('News');
	}
	
	function index(){
		$obj = $this->modelDao->where('category_id=130')->find();
		$this->assign('obj',$obj);
		$this->display();
	}
}


?>