<?php
class IndexAction extends MobileAction{
	
	function _initialize() {
		parent::_initialize();
	}
	
	function index(){
		
		$advs = M('Advert')->limit('5')->order('id asc')->select();
		$this->assign('advs',$advs);
		$this->display();
	}
}

?>