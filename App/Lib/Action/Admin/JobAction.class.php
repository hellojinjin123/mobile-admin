<?php

/**
 * 
 * 招聘管理控制器
 * @author uclnn
 *
 */
class JobAction extends AdminAction {
	
	function _initialize() {
		parent::_initialize ();
		$this->setModel('Job');
		$this->assign('c_root', $this->c_root = $_GET['mid']);
	}
	
	public function index() {
		
		if(empty($_GET['cid'])){
			
			$cid = M('Categorys')->where(array('model_id'=>$_GET['mid'],'fid'=>1))->order('id asc')->limit('0,1')->getField('id');
		}else{
			$cid = $_GET['cid'];
		}
		$obj =  M('Categorys')->where('id='.$cid)->find();
		if($obj['tpl_one']=='one'){
			
			$this->_oneContent($cid); //单页显示方式
		}else{
		
			$where = $this->pagewhere($cid);
			$this->_dataPage2($where);
			
			$this->assign('cid',$cid);
			$this->display ();
		}
	}
	
	//职位分类
	public function position() {	
		$_SESSION [C('USER_AUTH_KEY')]['backUrl'] = __APP__.'/Admin/Job/position';//返回列表连接
		$categoryDao = M('Category');
		$id = $categoryDao->getField('id', array('alias'=>'Job'));
		$_GET['pid'] = $id;
		$this->assign('c_root', $id);
		$this->assign('titleText', '职位');
		
		$this->_category();
	}
	
	//单页添加
	public function saveOne() {
		$this->_saveOne($_POST);
	}
	
	public function edit(){
		$this->_edit();
		$this->display ();
	}
	
	public function add(){
		$data = $_POST;
		//$data['begin_time'] = strtotime($data['begin_time']);
		//$data['end_time'] = strtotime($data['end_time']);
		$this->_add2($data);
	}

	public function update(){//var_dump($_POST);exit;
		//$_POST['begin_time'] = strtotime($_POST['begin_time']);
		//$_POST['end_time'] = strtotime($_POST['end_time']);
		$this->_update2($_POST);
	}
	
	public function delete(){
		try {
			$ids = $_POST ["ids"];
			$count = count ( $ids );
			for($i = 0; $i < $count; $i ++) {
				$numAndId = explode ( ',', $ids [$i] );
				$job_id = $numAndId [1];
				$this->_deleteResume( $job_id );
				$this->modelDao->delete ( $job_id );
			}
			$this->success ( '删除成功！' );
		} catch ( Exception $e ) {
			$this->error ( '异常：' . $e->getMessage () );
		}
	}
	
	public function deleteById(){
		try {
			$job_id = $_GET ['id'];
			$this->_deleteResume( $job_id );
			$this->modelDao->delete ( $job_id );
			$this->success ( '删除成功！' );
		} catch ( Exception $e ) {
			$this->error ( '异常：' . $e->getMessage () );
		}
	}
	
	//批量删除简历
	private function _deleteResume( $job_id ) {
		$jrDao = M('JobResume');
		$jrDao->where(array('job_id'=>$job_id))->delete();
	}
	
	//删除简历
	public function deleteResume() {
		$jrDao = M('JobResume');
		if( $jrDao->delete($_GET['id']) ) {
			$this->success('删除简历成功！');
		} else {
			$this->error('删除简失败！');
		}
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
}
?>