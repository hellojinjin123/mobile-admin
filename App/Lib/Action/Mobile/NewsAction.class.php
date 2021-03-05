<?php
class NewsAction extends MobileAction{
	
	function _initialize() {
		parent::_initialize();
		$this->setModel('News');
	}
	
	function index(){
		
		$category = M('Categorys')->where('fid=100')->order('id asc')->select();
		$this->assign('category',$category);
		$this->display();
	}
	
	function view(){
		$category = M('Categorys')->where('id='.$_GET['cid'])->find();
		$this->assign('category',$category);
		
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