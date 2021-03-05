<?php
/**
 *
 * 店铺形像控制器
 * @author uclnn
 *
 */
class StoreAction extends HomeAction
{
	function _initialize() {
		parent::_initialize();

	/*	if( $this->is_mobile==true ) {
			$maction = A("Home.Mobile");
			$maction->Store(); //店铺形象
			if( ACTION_NAME=='index' ) {
				$this->m_index();exit;
			}
		}*/

		if( !method_exists($this, ACTION_NAME) ) { //没有定制方法
			$this->display('index');exit;
		}
	}

	public function show() {
		$this->display('show');
	}


	/**********************************手机************************************/

	public function m_index() {
		
		$this->display($this->mobile_theme.':Store:index');
	}

}
?>