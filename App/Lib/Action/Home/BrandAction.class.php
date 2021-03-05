<?php
/**
 *
 * 品牌介绍控制器
 * @author uclnn
 *
 */
class BrandAction extends HomeAction {

	function _initialize() {
		parent::_initialize ();
		/*if( $this->is_mobile==true ) {
			$cid = isset($_GET["cid"])?$_GET["cid"]:740;	//设置默认值
			$maction = A("Home.Mobile");
			if( ACTION_NAME=='index' ) {
				$maction->cidNewsInfo($cid);
				$this->m_index();exit;
			} else if( ACTION_NAME=='show' ) {
				$maction->cidNewsInfo($cid);
				$this->m_show();exit;
			}
		}*/

		if (! method_exists ( $this, ACTION_NAME )) { // 没有定制方法
			$this->display ( 'index' );
			exit ();
		}
	}
	
	function m_show() {
		$this->assign('headTitle', '品牌介绍');
		$this->display($this->mobile_theme.':Brand:show');
	}
	function m_index(){
		$this->display($this->mobile_theme.':Brand:index');
	}

}
?>