<?php
/**
 * 
 * 信息管理控制器
 * @author uclnn
 *
 */
class NewsAction extends AdminAction {
	
	function _initialize() {
		parent::_initialize ();
		$this->setModel('News');
		
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
		
			$where['_string'] = "category_id like '$cid%'";
			$this->_dataPage2($where);
			
			$this->assign('cid',$cid);
			$this->display ();
		}
	}
	
	/*****资讯评论 方法 开始*****/
	function comment(){
		
		$model = M('Comment');
		import ( "ORG.Util.Page" );
		$count = $model->where ( array('ref_id'=>$_GET['id'],'type'=>'news') )->count ();
		$page = new Page ( $count, $rowpage );
		
		$list = $model->where(array('ref_id'=>$_GET['id'],'type'=>'news'))->order('id desc')->select();
		$this->assign('pageBar',$page->show());
		$this->assign('dataList',$list);
		$this->display();
		
	}
	
	public function comment_save(){
		$model = M('Comment');

		$_POST['reply_time'] = time();
		if($model->where(array('id'=>$_POST['id']))->save($_POST)){
			
			echo '1';
		}else{
			echo '0';
		}
		exit;
	}
	
	function setStatus(){
		
		$model = M('Comment');
		if($model->where(array('id'=>$_POST['id']))->save($_POST)){
			
			echo '1';
		}else{
			echo '0';
		}
		exit;
	}
	
	function comment_del(){
		$model = M('Comment');
		if($model->where(array('id'=>$_GET['id']))->delete()){
			
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
		
	}
	/*****资讯评论 方法 结束*****/
	
	//商品分类
	public function category( $cid ) {
		$_SESSION [C('USER_AUTH_KEY')]['backUrl'] = __APP__.'/Admin/News/category';//返回列表连接
		$_GET['pid'] = 19;
		$this->assign('c_root', 19);
		$this->assign('titleText', '分类');
		$where['alias'] = array(array('neq','news_category'));
		//$where['lang'] = $this->custom['def_lang'];
		$this->_category($where);
	}
	
	public function isHomeList($categoryDao) {
		$where['is_home'] = 1;
		$this->_dataPage( $categoryDao, $this->c_root, $where );
		$this->display ('index');exit;
	}
	
	public function isTopList($categoryDao) {
		$where['is_top'] = 1;
		$this->_dataPage( $categoryDao, $this->c_root, $where );
		$this->display ('index');exit;
	}
	
	public function isPublish1List($categoryDao) {
		$where['is_publish'] = 1;
		$this->_dataPage( $categoryDao, $this->c_root, $where );
		$this->display ('index');exit;
	}
	
	public function isPublish0List($categoryDao) {
		$where['is_publish'] = 0;
		$this->_dataPage( $categoryDao, $this->c_root, $where );
		$this->display ('index');exit;
	}
	
	
	//单页添加
	public function saveOne() {
		$this->_imgUploads('news');
		$this->_saveOne($_POST);
	}
	
	public function edit(){
		$this->_edit();
		$this->display ();
	}
	
	public function add(){
		$this->_imgUploads('news');
		$this->_add2($_POST);
	}

	public function update(){
		$this->_imgUploads('news');
		$this->_update2($_POST);
	}

	
	//删除封面
	public function deleteImage() {
		exit($this->_deleteImage('Public/data/upload/images/news/'));
	}
	
	public function delete(){
		if( isset( $_GET['id'] ) ) {
			$this->_deleteById();
		} else {
			$this->_delete();
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
	
	//手机同步默认语言
	public function synchMobile() {
		$this->_synchMobile();
	}
}
?>