<?php
 
class JobAction extends HomeAction {

	function _initialize() {
		parent::_initialize ();

		/*if( $this->is_mobile==true ) {
			$maction = A("Home.Mobile");
			if( ACTION_NAME=='index' ) {
				$maction->categoryList(25); //获取某个分类
				$this->m_index();exit;
			} else if( ACTION_NAME=='show' ) {
				$maction->newsInfo($_GET['cid']);
				$maction->cidNewsInfo($_GET['cid']);
				$this->m_show();exit;
			} else if( ACTION_NAME=='joinform' ) {
				$this->m_joinform();exit;
			}
		}*/

		if (! method_exists ( $this, ACTION_NAME )) { // 没有定制方法
			$this->display ( 'index' );
			exit ();
		}
	}
	
	function apply() {
		$this->display();
	}
	
	//保存留言
	public function joinSave() {
		if($_SESSION['verify'] != md5($_POST['verify'])) {
			exit('verify_error');
		}
		$joinDao = M('Joinin');
		$_POST['lang'] = cookie('think_language');
		$_POST['create_time'] = time();
		$bool = $joinDao->add($_POST);
		if( $bool!==false ) {
			exit('1');
		} else {
			exit('0');
		}
	}

	function m_index() {
		
		$this->display($this->mobile_theme.':Join:index');
	}
	
	function m_show() {
	/*	$newsDao = M('News');
		$obj = $newsDao->where(array('category_id'=>$_GET['cid'],'lang'=>'mobile','is_publish'=>1))->find();
		$this->assign('obj', $obj);
		$this->assign('headTitle', $obj['title']);*/
		$this->display($this->mobile_theme.':Join:show');
	}
	
	function m_joinform() {
		$this->assign('headTitle', '加盟咨询');
		$this->display($this->mobile_theme.':Join:form');
	}
	
	function m_addJoinform() {
		$joininDao = M('Joinin');
		$_POST['create_time'] = time();
		if( $joininDao->add($_POST)!==false ) {
			exit('success');
		} else {
			exit('error');
		}
	}

}
?>