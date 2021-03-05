<?php
/**
 *
 * 网络营销控制器
 * @author uclnn
 *
 */
class MarketAction extends HomeAction {

	function _initialize() {
		parent::_initialize ();

		/*if( $this->is_mobile==true ) {
			$maction = A("Home.Mobile");
			if( ACTION_NAME=='index' ) {
				$maction->market();
				$this->m_index();exit;
			}
		}*/

		if (! method_exists ( $this, ACTION_NAME )) { // 没有定制方法
			$this->display ( 'index' );
			exit ();
		}
	}
	
	public function index() {
    	$keyword = $_GET['keyword'];
    	if( !empty($keyword) ) {
    		$this->display('list');
    	} else {
			$this->display();
    	}
    }
	public function show(){
		$this->display();
	}
	
	function m_index() {
		$this->display($this->mobile_theme.':Market:index');
	}
	
	
	function m_map() {
		$marketDao = M('Market');
		$contact = $marketDao->where(array('category_id'=>$_GET['cid'],'lang'=>'mobile','is_publish'=>1,'image'=>'address'))->find();
		$this->assign('contact', $contact);
		$this->display($this->mobile_theme.':Inc:map');
	}
}
?>