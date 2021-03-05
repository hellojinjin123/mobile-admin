<?php
class CaseAction extends MobileAction{
	
	function _initialize() {
		parent::_initialize();
		$this->setModel('Case');
	}
	
	function index(){
		
		$this->assign('cid','140');
		$this->assign('pagesize',C('PAGE_SZIE'));
		$this->display();
	}
	
	function show(){
		
		$obj = $this->modelDao->where('id='.$_GET['id'])->find();
		$this->assign('obj',$obj);
		$this->display();
	}
	
}

?>