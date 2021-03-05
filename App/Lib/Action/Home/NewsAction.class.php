<?php
/**
 *
 * 新闻控制器
 * @author uclnn
 *
 */
class NewsAction extends HomeAction
{
	function _initialize() {
		parent::_initialize();

		/*if( $this->is_mobile==true ) {
			$maction = A("Home.Mobile");
			if( ACTION_NAME=='index' ) {
				$maction->banner();
				$maction->newsList($_GET['cid'],5);
				$this->m_index();exit;
			} else if( ACTION_NAME=='show' ) {
				$maction->newsInfo($_GET['id']);
				$this->m_show();exit;
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
		$this->display($this->mobile_theme.':News:index');
	}

	public function m_show() {
		$this->display($this->mobile_theme.':News:show');
	}

}
?>