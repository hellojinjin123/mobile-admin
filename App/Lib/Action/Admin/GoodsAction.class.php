<?php
/**
 * 
 * 产品控制器
 * @author uclnn
 *
 */
class GoodsAction extends AdminAction {
	function _initialize() {
		parent::_initialize ();
		$this->list_pid = 420;
		$this->setModel('Goods');
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
	
	public function isHomeList($categoryDao) {
		$where['is_home'] = 1;
		$this->_dataPage( $categoryDao, $this->c_root, $where );
		$this->display ('index');
	}
	
	/*****资讯评论 方法 开始*****/
	function comment(){
		
		$model = M('Comment');
		import ( "ORG.Util.Page" );
		$count = $model->where ( array('ref_id'=>$_GET['id'],'type'=>'product') )->count ();
		$page = new Page ( $count, $rowpage );
		
		$list = $model->where(array('ref_id'=>$_GET['id'],'type'=>'product'))->order('id desc')->select();
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
	
	
	
	public function isTopList($categoryDao) {
		$where['is_top'] = 1;
		$this->_dataPage( $categoryDao, $this->c_root, $where );
		$this->display ('index');
	}
	
	public function isPublish1List($categoryDao) {
		$where['is_publish'] = 1;
		$this->_dataPage( $categoryDao, $this->c_root, $where );
		$this->display ('index');
	}
	
	public function isPublish0List($categoryDao) {
		$where['is_publish'] = 0;
		$this->_dataPage( $categoryDao, $this->c_root, $where );
		$this->display ('index');
	}
	
	public function upfile(){
		
		$dir = C('UPLOAD_FILE_RULE').'images/goods/';
		$this->_upload2($dir);
	}
	
	//商品分类
	public function category( $cid ) {
		$_SESSION [C('USER_AUTH_KEY')]['backUrl'] = __APP__.'/Admin/Goods/category';//返回列表连接
		$_GET['pid'] = 20;
		$this->assign('c_root', 20);
		$this->assign('titleText', '分类');
		$where['alias'] = array(array('neq','goods_category'),array('neq','goods_recommend'));
		//$where['lang'] = $this->custom['def_lang'];
		$this->_category($where);
	}
	
	
	public function upload(){
				
		$this->display ();
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
		$this->_imgUploads('goods');
		try {
			$data = $this->_processData($_POST);
			
			if ($this->modelDao->add ( $data )) {
				$good_id = $this->modelDao->getLastInsID();
				
				if (isset($data['synch_mobile'])) {
					$this->getModileCategoryId($data);
					$this->_synchMobile($this->modelDao->getLastInsID(),$data);exit;
				}
				
				$this->_updateCategoryListCount($data['category_id'],'','add');
				//默认语言添加
				$last_id = $this->modelDao->getLastInsID();
				
				$this->modelDao->where(array('id'=>$last_id))->setField(array('my_id','lang'),array($last_id,$this->lang));
				
				//批量插入图片			
				$gphoto = D('goods_photo');
				for($i=0;$i<count($_POST['phototitle']);$i++){				
					$gphoto->add(array('title'=>$_POST['phototitle'][$i],'image'=>$_POST['photofilename'][$i],'goods_id'=>$good_id,'is_publish'=>1));
					 
				}
								 
				$this->assign('jumpUrl', __APP__.'/Admin/'.MODULE_NAME.'/index/mid/'.$_POST['mid']);
				$this->success ( '添加成功！' );
			} else {
				//$this->assign('jumpUrl', __APP__.'/Admin/'.MODULE_NAME.'/index');
				$this->error ( '添加失败！' );
			}
		} catch ( Exception $e ) {
			$this->error ( '异常：' . $e->getMessage () );
		}
		

	}

	public function update(){
		if(!empty($_FILES['image']['name'])){
			$dir = C('UPLOAD_FILE_RULE').'images/goods/';
			$imgwidth = $_POST['imgwidth'];
			$imgheight = $_POST['imgheight'];
			if( !empty($_FILES['image']['name']) && !empty( $imgwidth ) && !empty( $imgheight ) ) {
				$this->_img_upload($dir,'image',true,$imgwidth,$imgheight);
			} elseif( !empty($_FILES['image']['name'] )) {
				$this->_img_upload($dir,'image');
			}
		}
		//批量插入图片								
		$gphoto = D('goods_photo');
		$photoList = $gphoto->where(array('goods_id'=>$_POST['id']))->select(); 
		foreach($photoList as $value){$plist[] = $value['image']; }
		
		$delid  = explode(',', $_POST['delphotoid']);
		for($i=0;$i<count($_POST['phototitle']);$i++){
			$post = array('title'=>$_POST['phototitle'][$i],'image'=>$_POST['photofilename'][$i],'goods_id'=>$_POST['id'],'is_publish'=>1);	
			if($photoList[$i]['image'] == $_POST['photofilename'][$i]){ //更新原有图片
				
				$gphoto->where('id='.$_POST['photofileid'][$i])->save($post);		
			}elseif(!in_array($_POST['photofilename'][$i], $plist)){ //添加新图片	 			
				$gphoto->add($post);
			}			
		}
		if($delid){ //删除图片
			foreach($delid as $valid){
				$gphoto->where('id='.$valid )->delete();
			}
		}
				
		$this->_update2($_POST);
	}
	
	public function delete(){
		$this->_delete();
	}
	
	public function deleteById(){
		$this->_deleteById();
	}
	
	//删除封面
	public function deleteImage() {
		exit($this->_deleteImage('Public/data/upload/images/goods/'));
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