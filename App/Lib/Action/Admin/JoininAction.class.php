<?php
/**
 * 
 * 在线加盟管理控制器
 * @author uclnn
 *
 */
class JoininAction extends AdminAction {	
	
	function _initialize() {
		parent::_initialize ();		
		$this->setModel('Joinin');
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
		$_GET['root'] = 25;
		$data['read'] = 1;
		$this->modelDao->where(array('id'=>'1'))->save($data);
		$this->_edit();
		$this->display ();
	}
	
	public function add(){
		
		$this->_add2($_POST);
	}

	public function update(){
		$this->_update2($_POST);
	}
	
	//单页添加
	public function saveOne() {
		$this->_imgUploads('news');
		$this->_saveOne($_POST);
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

	public function joinin_apply()
	{
		$rowpage = empty($rowpage)?10:$rowpage;
		$this->assign('dataList', $this->page($where, $rowpage));
		$this->assign('rowpage', $rowpage);
		$this->assign('searchKey', empty($searchKey)?'请输入关键字':$searchKey);
		$this->display ();
	}
}
?>