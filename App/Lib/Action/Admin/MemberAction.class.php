<?php
/**
 * 
 * 会员管理控制器
 * @author uclnn
 *
 */
class MemberAction extends AdminAction {
	
	function _initialize() {
		parent::_initialize ();
		$this->setModel('Member');
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
	
	public function edit(){
		$member = $this->modelDao->find($_GET['id']);
		$this->assign('obj', $member);
		$this->display ();
	}

	public function delete(){
		$this->_delete();
	}
	
	public function deleteById(){
		$this->_deleteById();
	}
	
	public function ordernum(){
		$this->_ordernum();
	}
	
	public function move(){
		$this->_move();
	}

	public function isPublish() {
		$this->_updateField('is_publish');
	}

}
?>