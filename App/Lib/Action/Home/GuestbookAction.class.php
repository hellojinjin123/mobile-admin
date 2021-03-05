<?php
/**
 *
 * 留言板控制器
 * @author uclnn
 *
 */
class GuestbookAction extends HomeAction {

	function _initialize() {
		parent::_initialize ();

		/*if( $this->is_mobile==true ) {
			if( ACTION_NAME=='index' ) {
				$this->m_index();exit;
			} else if( ACTION_NAME=='joinform' ) {
				$this->m_joinform();exit;
			}
		}*/

		if (! method_exists ( $this, ACTION_NAME )) { // 没有定制方法
			$this->display ( 'index' );
			exit ();
		}
	}
	
	function view() {
		$this->display('view');
	}
	function show() {
		$this->display('show');
	}
	
	//保存留言
	public function guestbookSave() {
		if($_SESSION['verify'] != md5($_POST['verify'])) {
			exit('verify_error');
		}
		$guestbookDao = M('Guestbook');
		$_POST['lang'] = cookie('think_language');
		$_POST['create_time'] = time();
		$bool = $guestbookDao->add($_POST);
		if( $bool!==false ) {
			exit('1');
		} else {
			exit('0');
		}
	}

	function m_index() {
		$this->assign('headTitle', '在线留言');
		$this->display($this->mobile_theme.':Guestbook:index');
	}
	
	function m_addGuestbook() {
		$guestbookDao = M('Guestbook');
		$_POST['create_time'] = time();
		if( $guestbookDao->add($_POST)!==false ) {
			exit('success');
		} else {
			exit('error');
		}
	}

}
?>