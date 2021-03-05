<?php

/**
 *
 * 手机网站信息
 * @author uclnn
 *
 */
class MobileWebsiteAction extends AdminAction
{

	function _initialize() {
		parent::_initialize ();
		$this->setModel('MobileWebsite');
		$this->assign('c_root', $this->c_root = 30);
	}
	public function index() {
		$cid = $_REQUEST['cid'];
		if( !empty( $cid ) ) {
				
			$categoryDao = D('Admin.Category');
			$category = $categoryDao->field('alias,tpl_one')->where(array('id'=>$cid))->find();
			$alias = $category['alias'];
			$tpl_one = $category['tpl_one'];
	
			if( $tpl_one=='auto' ) { //设置呈现样式为“自动”会自动选择下一级的第一个分类
				$this->goToCategoryFirst( $cid );
			} elseif( $tpl_one=='one' ) {
				$this->_oneContent($cid); //单页显示方式
			}
	
			//推荐管理
			if( $alias=='MobileBase' ) {
				$this->base();exit;
			} elseif( $alias=='MobileSEO' ) {
				$this->seo();exit;
			} elseif( $alias=='MobileDomain' ) {
				$this->domain();exit;
			} elseif( $alias=='MobileTheme' ) {
				$this->theme();exit;
			}

			//if($this->lang!='all') $where['lang']=$this->lang;
			$this->_dataPage($categoryDao, $cid, $where);
				
			$this->display ();
		} else {// 点击主导航重定向到第一个分类
			$this->goToCategoryFirst( $this->c_root );
		}
	}
	
	//基本设置
	public function base() {
		$systemDao = M ( 'System' );
		$this->assign ( 'system', $systemDao->where ( array ('lang' => 'mobile') )->find () );
		$this->display ('base');
	}
	
	//手机主题
	public function theme() {
		$systemDao = M ( 'System' );
		$this->assign ( 'system', $systemDao->where ( array ('lang' => 'mobile') )->find () );
		$this->display ('theme');
	}
	
	//全局SEO
	public function seo() {
		$systemDao = M ( 'System' );
		$this->assign ( 'system', $systemDao->where ( array ('lang' => 'mobile') )->find () );
		$this->display ('seo');
	}
	
	//多域名
	/*public function domain() {
		$systemDao = M ( 'System' );
		$this->assign ( 'system', $systemDao->where ( array ('lang' => 'mobile') )->find () );
		$this->display ('domain');
	}
	*/
	public function saveBase() {
		try {
			$dir = C('UPLOAD_FILE_RULE').'images/mobile/';
			if( !empty($_FILES['image']['name'] )) {
				$this->_img_upload($dir,'image',false);
			}
			$this->setModel ( 'System' );
			$where ['lang'] = $_POST ['lang'];
			$count = $this->modelDao->where ( $where )->count ();
			$_POST['weibo_plug'] = str_replace('\\','',$_POST['weibo_plug']);
			$_POST['shareInfo'] = str_replace('\\','',$_POST['shareInfo']);
			if ($count > 0) {
				$this->modelDao->where ( $where )->save ( $_POST );
				$this->success ( '修改成功！' );
			} else {
				$this->_add ( $_POST );
			};
		} catch ( Exception $e ) {
			$this->error ( '异常：' . $e->getMessage () );
		}
	}
	
	public function saveSEO() {
		try {
			$this->setModel ( 'System' );
			$where ['lang'] = $_POST ['lang'];
			$count = $this->modelDao->where ( $where )->count ();
			if ($count > 0) {
				$this->modelDao->where ( $where )->save ( $_POST );
				$this->success ( '修改成功！' );
			} else {
				$this->_add ( $_POST );
			}
		} catch ( Exception $e ) {
			$this->error ( '异常：' . $e->getMessage () );
		}
	}

	//编辑手机网站信息
	public function edit() {
		$this->_edit();
		$this->display ();
	}

	public function add(){
		$_POST['content_type'] = $this->getContentType($_POST['content'],$_POST['url']);
		$this->_add2($_POST);
	}
	
	public function delete(){
		if( isset( $_GET['id'] ) ) {
			$this->_deleteById();
		} else {
			$this->_delete();
		}
	}
	
	//删除Logo
	public function deleteImage() {
		$this->setModel('System');
		exit($this->_deleteImage('Public/data/upload/images/mobile/'));
	}

	public function update(){
		$_POST['content_type'] = $this->getContentType($_POST['content'],$_POST['url']);
		$this->_update2($_POST);
	}

	public function isPublish() {
		$this->_updateField('is_publish');
	}

	public function isHome() {
		$this->_updateField('is_home');
	}
	
	public function isContact() {
		$this->_updateField('is_contact');
	}

	public function ordernum(){
		$this->_ordernum();
	}
	public function domain() {
		$systemDao = M ( 'System' );
		$domain = M('domain');
		$this->assign( 'domain' , $domain->select());
		$this->assign ( 'system', $systemDao->where ( array ('lang' => 'mobile') )->find () );
		$this->display ('Mobile/domain');
	}
	//返回内容类型,如：abc@huyi.cn格式返回 email字符串
	private function getContentType( $str ,$url = 'null' ) {

		if(ereg("^http(s)*://[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*$", $str)){
			return 'http';
		}
		if(ereg("^([a-z0-9_]|\-|\.)+@(([a-z0-9_]|\-)+\.)+[a-z]{2,4}$", $str)){
			return 'email';
		}
		
		if(preg_match( '/^\+?\d{11}$/', $str )){
			return 'mobile';
		}
		if(preg_match('/^[0-9]{3,4}-[0-9]{7,8}$/',$str)){
			return 'phone';
		}
		if($url != 'null')
		{
			return 'dimensional';
		}
		return '';
	}









































	public function ajaxtree () {
		$def_lang = $this->custom['def_lang'];
		$id = $_POST["id"];
		$value = $_POST['value'];
		$categoryDao = M('Category');

		if( $value=='root' ) {
			$categoryList = $categoryDao->where(array('is_mobile'=>1,'pid'=>12,'id'=>array('in',$this->custom['modules'])))->select();
		} else {
			$categoryList = $categoryDao->where(array('pid'=>$id,'is_publish'=>1,'is_fixed'=>0,'lang'=>$def_lang))->select();
		}
		foreach ($categoryList as $key=>$value) {
			$child_count = $categoryDao->where(array('pid'=>$value['id'],'is_publish'=>1,'is_fixed'=>0,'lang'=>$def_lang))->count();
			if( $child_count > 0 ) {
				$hasChildren = true;
			} else {
				$hasChildren = false;
			}
			$is_mobile = $categoryDao->getField('is_mobile',array('id'=>$value['id']));
			$ret[] = array(
					"id" => $value['id'],
					"text" => $value['title'],
					"value" => $value['id'],
					"showcheck" => true,
					"complete" => false,
					"isexpand" => false,
					"checkstate" => $is_mobile,
					"hasChildren" => $hasChildren
			);
		}
		header('Content-type:text/javascript;charset=UTF-8');
		exit(json_encode($ret));
	}

	//设置手机显示
	public function isMobile() {
		$categoryDao = D('Admin.Category');
		$id = $_GET['id'];
		$levels = $categoryDao->getUpLevels($id);
		$checkstate = $_GET['checkstate'];
		$categoryDao->where(array('id'=>array('in',str_replace('|', ',', $levels))))->setField('is_mobile', 1);
		$result = $categoryDao->where(array('id'=>$id))->setField('is_mobile', $checkstate==0?1:0);
		exit($result);
	}

}
?>