<?php
/**
 *
 * 系统设置
 * @author uclnn
 *
 */
class SystemAction extends AdminAction {
	
	function _initialize() {
		parent::_initialize ();
		$this->assign('c_root', $this->c_root=$_GET['mid']);
		$this->setModel ( 'System' );
		$system = $this->modelDao->find();
		$this->assign('system',$system);
	}
	
	public function index() {
		
		$this->redirect('User/index/mid/'.$_GET['mid']);
	}
	
	function users(){
		
		$this->redirect('User/index/mid/'.$_GET['mid']);
	}
	
	public function website() {
		$this->display ( 'website' );
	}

	public function seo() {
		$this->display ( 'seo' );
	}

	public function email() {
		$this->display ( 'email' );
	}

	// 保存基本设置、SEO设置、邮箱设置
	public function saveSetting() {
		
		try {
			
			if (!empty($_POST['id'])) {
				
				
				if($this->modelDao->where('id='.$_POST['id'])->save($_POST)){
					
					$this->success ( '修改成功！' );
				}else{
					$this->error ( '修改失败！' );
				}
			} else {
				$this->_add ( $_POST );
			}
		} catch ( Exception $e ) {
			$this->error ( '异常：' . $e->getMessage () );
		}
	}

	// ajax获取空间大小
	public function getSpaceSize() {
		echo getRealSize ( $this->getDirSize ( dirname ( $_SERVER [SCRIPT_FILENAME] ) ) );
	}

	// 获取虚拟空间使用大小
	private function getDirSize($dir) {
		$handle = opendir ( $dir );
		while ( false !== ($FolderOrFile = readdir ( $handle )) ) {
			if ($FolderOrFile != "." && $FolderOrFile != "..") {
				if (is_dir ( "$dir/$FolderOrFile" )) {
					$sizeResult += $this->getDirSize ( "$dir/$FolderOrFile" );
				} else {
					$sizeResult += filesize ( "$dir/$FolderOrFile" );
				}
			}
		}
		closedir ( $handle );
		return $sizeResult;
	}
}
?>