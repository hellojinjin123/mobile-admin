<?php
/**
 *
 * 联系我们控制器
 * @author uclnn
 *
 */
class ContactAction extends HomeAction {

	function _initialize() {
		parent::_initialize ();

		/*if( $this->is_mobile==true ) {
			if( ACTION_NAME=='show' ) {
				$this->m_show();exit;
			}else if( ACTION_NAME == 'index' )
				{
					$this->m_index();
					exit;
			}
		}*/

		if (! method_exists ( $this, ACTION_NAME )) { // 没有定制方法
			$this->display ( 'index' );
			exit ();
		}
	}

	function m_show() {
		$this->assign('headTitle', '联系我们');
		$this->display($this->mobile_theme.':Contact:show');
	}
	function m_index() {
		$this->assign('headTitle', '联系我们');
		$this->display($this->mobile_theme.':Contact:index');
	}
	
	function m_map() {
		$mwDao = M('MobileWebsite');
		$contact = $mwDao->where(array('image'=>'address','is_publish'=>1))->find();
		$this->assign('contact', $contact);
		$this->display($this->mobile_theme.':Inc:map');
	}
	
	function m_weibo() {
		$systemDao = M('System');
		$system = $systemDao->where(array('lang'=>'mobile'))->find();
		$this->assign('headTitle', '企业微博');
		$this->assign('system',$system);
		$this->display($this->mobile_theme.':Contact:weibo');
	}

}
?>