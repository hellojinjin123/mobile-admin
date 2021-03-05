<?php
/**
 *
 * 关于我们控制器
 * @author uclnn
 *
 */
class AboutAction extends HomeAction {

	function _initialize() {
		parent::_initialize ();
		/*if( $this->is_mobile==true ) {
			$maction = A("Home.Mobile");
			$_GET['cid'] = isset($_GET["cid"])?$_GET["cid"]:"703";
			if( ACTION_NAME=='index' ) {
				$maction->cidNewsInfo($_GET['cid']);
				$this->m_index();exit;
			} else if( ACTION_NAME=='show' ) {
				$maction->cidNewsInfo($_GET['cid']);
				$this->m_show();exit;
			}
		}*/

		if (! method_exists ( $this, ACTION_NAME )) { // 没有定制方法
			$this->display ( 'index' );
			exit ();
		}
	}

	function m_index() {
		$this->display($this->mobile_theme.':About:index');
	}
	
	function m_show() {
		$this->display($this->mobile_theme.':About:show');
	}

}
?>