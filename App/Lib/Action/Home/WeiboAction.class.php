<?php
/**
 *
 * 关于我们控制器
 * @author uclnn
 *
 */
class WeiboAction extends HomeAction {

	function _initialize() {
		parent::_initialize ();
		/*if( $this->is_mobile==true ) {
			$this->assign('headTitle','企业微博');
			$maction = A("Home.Mobile");
			if( ACTION_NAME=='index' ) {
				$this->m_index();exit;
			} else if( ACTION_NAME=='show' ) {
				$this->m_show();exit;
			}
		}*/

		if (! method_exists ( $this, ACTION_NAME )) { // 没有定制方法
			$this->display ( 'index' );
			exit ();
		}
	}

	function m_index() {
		$this->display($this->mobile_theme.':Weibo:index');
	}
	
	function m_show() {
		$this->display($this->mobile_theme.':Weibo:show');
	}

}
?>