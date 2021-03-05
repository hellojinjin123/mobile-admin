<?php
class SettingAction extends AdminAction {
	
	function _initialize() {
		parent::_initialize ();
	}
	
	public function index() {
		
		
		
		$model = M('modelconfig');
		$modellist = $model->order('id asc')->select();
		$this->assign('modellist',$modellist);
		
		$this->display ();
	}
	
	function addModel(){
		
		$this->setModel('Modelconfig');
		if(empty($_POST['id'])){
			$this->_add($_POST);
		}else{
			$this->_update($_POST);
		}
		
	}
	
	function modelnamecheck(){
		$obj = M('Modelconfig')->where("modelname='".$_REQUEST['modelname']."'")->find();
		if(empty($obj)){
			echo '1';
		}else{
			echo '0';
		}
	}
	
	function modelactioncheck(){
		
		$obj = M('Modelconfig')->where("modelaction='".$_REQUEST['modelaction']."'")->find();
		if(empty($obj)){
			echo '1';
		}else{
			echo '0';
		}
		
	}
	
	function selectOptionModel(){
		
		$dataList = M('Modelconfig')->order('id asc')->select();
		$options = '<option value="" selected>请选择</option>';
		foreach ($dataList as $key => $value) {
			
			$options .= '<option value="'.$value['id'].'" >'.$value['modelname'].'</option>';
		}
		exit($options);
	}
	
	function is_selModel(){
		
		$dataList = M('Modelconfig')->where('is_sel=1')->order('id asc')->select();
		$options = '<option value="" selected>请选择</option>';
		foreach ($dataList as $key => $value) {
			
			$options .= '<option value="'.$value['id'].'" >'.$value['modelname'].'</option>';
		}
		exit($options);
		
	}
	
	function getModel(){
		
		$obj = M('Modelconfig')->where('id='.$_REQUEST['id'])->find();
		exit(json_encode($obj));
	}
	
	function deleteModel(){
		
		$id = $_REQUEST ['id'];
		if (! empty ( $id )) {
			$categoryDao = M ( 'Categorys' );
									
			$count = $categoryDao->where ( array('model_id'=>$id) )->count ();
			if ($count > 0) { //存在子分类不能删除
				exit('sub_exist');
			} else {

				$result = M('Modelconfig')->where('id='.$id)->delete();
				if( $result!==false ) {
					exit('true');
				} else {
					exit('false');
				}
			}
		}
	}
	
	function selModel(){
		
		if(M('Modelconfig')->where('id='.$_GET['id'])->save(array('is_sel'=>$_GET['is_sel']))){
			
			echo '1';
		}else{
			echo '0';
		}		
	}
	
	
	function selectOptionColumn(){
		
				
		$dataList = M('Categorys')->where('fid='.$_REQUEST['fid'].' and model_id='.$_REQUEST['m_id'])->order('id asc')->select();
		
		$options = '<option value="" selected>请选择</option>';
		foreach ($dataList as $key => $value) {
			$options .= '<option value="'.$value['id'].'">'.$value['title'].'</option>';
		}
		exit($options);
	}
	
	function addColumn(){
		
		if(empty($_REQUEST['id'])){
			$_POST['id'] = $this->getSelfCateID($_POST['fid']);	
			
			if(M('Categorys')->add($_POST)){
				if($_POST['fid']==1){
					$model = new Model();
					$sql = "update m_modelconfig set is_column=is_column+1 where id=".$_POST['model_id'];
					$model->query($sql);
					
					
				}else{
					$model = new Model();
					$sql = "update m_categorys set is_child=is_child+1 where id=".$_POST['fid'];
					$model->query($sql);
					
				}
				echo '1';
			}else{
				echo '0';
			}		
			
			
		}else{
			$this->setModel('Categorys');
			$this->_update($_POST);
		}
	}
		
	function getSelfCateID($fid){
			
			$model = M('Categorys');
			if($fid=='1'){
				$result = $model->where('fid=1')->max('id');
				if(empty($result)){
					$cateid = '100';
				}else{
					$cateid = $result + 10;
				}		
			}else{			
				$result = $model->where('fid='.$fid)->max('id');
				if(empty($result)){
					$cateid = $fid.'10';				
				}else{
					$cateid = $result + 1;
				}		
			}
			return $cateid;
		}
	
	function getCategory(){
		$obj = M('Categorys')->where('id='.$_REQUEST['id'])->find();
		
		exit(json_encode($obj));
	}
	
	function deleteColumn(){
		
			$id = $_REQUEST ['id'];
		if (! empty ( $id )) {
			$categoryDao = M ( 'Categorys' );
			$catedata = $categoryDao->where('id='.$id)->find();						
			$count = $categoryDao->where ( array('fid'=>$id) )->count ();
			if ($count > 0) { //存在子分类不能删除
				exit('sub_exist');
			} else {

				$result = $categoryDao->where('id='.$id)->delete();
				if( $result!==false ) {
					if($catedata['fid']==1){
						$model = new Model();
						$sql = "update m_modelconfig set is_column=is_column-1 where id=".$catedata['model_id'];
						$model->query($sql);
						
						
					}else{
						$model = new Model();
						$sql = "update m_categorys set is_child=is_child-1 where id=".$catedata['fid'];
						$model->query($sql);
						
					}
					
					exit('true');
				} else {
					exit('false');
				}
			}
		}
	}
	
	
	
	
	
	
	
	
	
	
	
}


?>