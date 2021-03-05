<?php
/**
 * 
 * 分类管理
 * @author uclnn
 *
 */
class CategoryAction extends AdminAction {
	
	function _initialize() {
		parent::_initialize ();
		$this->setModel('Categorys');
	}
	
	public function index() {
		$categoryList = $this->modelDao->where(array('model_id'=>$_GET['mid'],'fid'=>1))->order('id asc')->select();
				
		$this->assign('mid',$_GET['mid']);
		$this->assign('categoryList',$categoryList);	
		$this->display();
	}
	
	public function edit(){
		
		$categoryList = $this->modelDao->where(array('model_id'=>$_GET['mid'],'fid'=>1))->order('id asc')->select();
		$this->assign('categoryList',$categoryList);	
		$this->assign('mid',$_GET['mid']);
		
		if($_REQUEST['act']=='update'){
			$catedata = $this->modelDao->where('id='.$_GET['id'])->find();			
			$this->assign('catedata',$catedata);
		}
		$this->assign('act',$_GET['act']);
		$this->assign('id',$_GET['id']);
		
		
		
		$this->display();
		
	}
	
	public function categoryManage(){

		if($_POST['act']=='update'){
			
			
			$res = $this->modelDao->save ( $_POST );
			if($res!==false){
				
				$this->assign('jumpUrl', __APP__.'/Admin/Category/index/mid/'.$_POST['model_id']);
				$this->success('分类修改成功');
			}else{
				$this->error('分类修改失败');
			}
			
		}else{
			
			$_POST['id']= $this->getCateID($_POST['fid']);
			if($this->modelDao->add($_POST)){
				if($_POST['fid']!=1){
					
					$sql = "update m_categorys set is_child=is_child+1 where id=".$_POST['fid'];
					$model = new Model();
					$model->query($sql);
									
				}
				$this->assign('jumpUrl', __APP__.'/Admin/Category/index/mid/'.$_POST['model_id']);
				$this->success('分类添加成功');
			}else{
				$this->error('分类添加失败');
			}
			
		}
		
	}	

	
	function getCateID($fid){
		
		
		if($fid=='1'){
			$result = $this->modelDao->where('fid=1')->max('id');
			if(empty($result)){
				$cateid = '100';
			}else{
				$cateid = $result + 10;
			}		
		}else{			
			$result = $this->modelDao->where('fid='.$fid)->max('id');
			if(empty($result)){
				$cateid = $fid.'10';				
			}else{
				$cateid = $result + 1;
			}		
		}
		return $cateid;
	}
	
	function delete(){
		$cate = $this->modelDao->where('id='.$_GET['id'])->find();
		if($this->modelDao->where('id='.$_GET['id'])->delete()){
			if($cate['fid']!=1){
					$sql = "update m_categorys set is_child=is_child-1 where id=".$cate['fid'];
					$model = new Model();
					$model->query($sql);				
			}
			$this->success('分类删除成功');
		}else{
			$this->error('分类删除失败');
		}
	}
	

}
?>