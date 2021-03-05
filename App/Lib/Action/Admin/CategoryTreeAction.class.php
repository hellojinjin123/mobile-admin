<?php
/**
 * 
 * 商品分类管理
 * @author uclnn
 *
 */

import("@.Action.Admin.CategoryAction");

class CategoryTreeAction extends CategoryAction {
	
	function _initialize() {
		parent::_initialize ();
		$this->c_root = $_GET['c_root'];
		$this->assign('c_root', $this->c_root);
	}
	
	public function index() {
		
	}

	//树节点
	public function treeNode() {
		$pid = $_REQUEST ['id'];
		if (empty ( $pid ))
			$pid = $this->c_root;
		
		$categoryDao = M ( 'Category' );
		$where ['pid'] = $pid;
		$where ['lang'] = $this->lang;
		$listData = $categoryDao->where ( $where )->order('ordernum desc')->select ();
		foreach ( $listData as $key => $value ) {
			$count = $categoryDao->where ( array ('pid' => $value ['id'], 'title'=>array('neq',''), 'lang'=>$this->lang ) )->count ();
			if ($count > 0)
				$data [$key] ['isParent'] = true;
			$data [$key] ['id'] = $value ['id'];
			$data [$key] ['name'] = $value ['title'];
		}
		exit ( json_encode ( $data ) );
	}

	//编辑
	public function edit(){
		$this->getCategory();
		$this->assign('act', $_GET['act']);
		$this->display('Category/edit-tree');
	}
	
	//更新分类
	public function update(){
		$this->setModel('Category');
		$this->assign('act', $_GET['act']);
		$this->_update($_POST);
	}
	
	//添加分类
	public function add() {
		$this->setModel('Category');
		$data = $_POST;
		$pid = $data['pid'];
		if( $pid == $this->c_root ) {
			$data['levels'] = $pid;
		} else {
			$levels = $this->modelDao->getField('levels', array('id'=>$pid));
			$data['levels'] = $levels.'|'.$pid;
		}
		$this->_add($data);
	}
	
	//删除分类
	public function deleteTreeNode() {
		$this->deleteCategory();
	}
	
	//移动分类
	public function move() {
		$pid = $_REQUEST['pid'];
		$id = $_REQUEST['id'];
		
		if( !empty($pid) && !empty($id) && $pid!==$id ) {
			$categoryDao = M ( 'Admin.Category' );
			$data['levels'] = $categoryDao->getUpLevels($pid);
			$data['pid'] = $pid;
			$data['id'] = $id;
			echo $categoryDao->save($data);
		}
	}
	
	//通过不同语言获取分类
	public function getCategoryByLang() {
		$categoryDao = M('Category');
		$category = $categoryDao->where(array('my_id'=>$_GET['my_id'], 'lang'=>$_GET['lang']))->find();
		exit(json_encode($category));
	}


}
?>