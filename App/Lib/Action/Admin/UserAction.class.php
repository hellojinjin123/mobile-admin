<?php
// 后台用户模块
class UserAction extends AdminAction {
	
	function _initialize() {
		parent::_initialize ();
		$this->setModel('Admin');
		$this->assign('c_root', $this->c_root=$_GET['mid']);
	}
	
	public function index() {
		$rowpage = $_REQUEST['rowpage'];
		$rowpage = empty($rowpage)?10:$rowpage;
		$this->assign('dataList', $this->page($where, $rowpage));
		$this->assign('rowpage', $rowpage);
		$this->display ('User/index');
	}

	public function edit() {
		$id = $_GET['id'];
		if( !empty($id) ) {
			$user = $this->modelDao->find($id);
			$this->assign('obj', $user);
		}
		$this->display();
	}
	
	//授权
	public function accredit() {
			$accessDao = M('User_access');
		
			$this->_assignModuleList();
			
			$user = $accessDao->where('uid='.$_GET['id'])->find();
			
			$access = json_decode($user['access'],true);
			
			$this->assign('access',$access);
			$this->assign('obj', $user);
			$this->assign('uid', $_GET['id']);
			$this->display();
		
	}

	function accredit_save(){
		$model = M('User_access');
		$obj = $model->where('uid='.$_POST['uid'])->find();
		if($obj){
						
			$id = $_POST['id'];
			unset($_POST['id']);unset($_POST['uid']);unset($_POST['__hash__']);			
			$data['access'] = json_encode($_POST);
			//dump($data);
			//exit;
			$res = $model->where('id='.$id)->save($data);
			if($res!==false){
				
				$this->success('授权成功');
			}else{
				$this->error('授权失败');
			}
		}else{
			
			$data['uid'] = $_POST['uid'];
			$data['create_time'] = time();
			unset($_POST['id']);unset($_POST['uid']);unset($_POST['__hash__']);
			
			$data['access'] = json_encode($_POST);
			
			if($model->add($data)){
				
				$this->success('授权成功');
			}else{
				$this->error('授权失败');
			}
		}
		
	}
	
	public function add(){
		$data = $_POST;
		$data['password'] = md5($data['password']);
		$this->_add2($data);
	}

	public function update(){
		$data = $_POST;
		$password = trim($data['password']);
		if( empty($password) ) {
			unset($data['password']);
		} else {
			$data['password'] = md5($password);
		}
		$result = $this->modelDao->save ( $data );
		if(false !== $result) {
			$this->success ( '修改成功！');
		} else {
			$this->error ( '修改失败！');
		}
	}


	//重置密码
	public function password() {
		if( $this->isPost() ) {
			$admin_id = $_SESSION['admin']['id'];
			$oldpassword = $_POST['oldpassword'];
			$count = $this->modelDao->where(array('id'=>$admin_id, 'password'=>md5($oldpassword)))->count();
			if( $count == 0 ) {
				$this->error('旧的密码不一致！');
			}
			
			$password = $_POST['password'];
			$repassword = $_POST['repassword'];
			if( $repassword != $password ) {
				$this->error('两次输入密码不一致！');
			}
			
			$data['password'] = md5($password);
			$data['id'] = $admin_id;
			$result	= $this->modelDao->save($data);
			if(false !== $result) {
				$this->success("密码修改为 $password");
			}else {
				$this->error('重置密码失败！');
			}
		} else {
			$this->display('');
		}
	}
	
	public function isPublish() {
		$this->_updateField('is_publish');
	}
	
	public function deleteById() {
		$this->_deleteById();
	}
	
}
?>