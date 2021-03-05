<?php
/**
 *
 * 关于我们控制器
 * @author uclnn
 *
 */
class JobssAction extends HomeAction {

	function _initialize() {
		parent::_initialize ();
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