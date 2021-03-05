<?php
/**
 * 
 * 产品控制器
 * @author uclnn
 *
 */
class GoodsAction extends HomeAction
{
	function _initialize() {
        parent::_initialize();
       /* if( $this->is_mobile==true ) {
			$maction = A('Home.Mobile');
            if( ACTION_NAME=='index' ) {
				$maction->productList($_REQUEST['cid']); //产品列表
                $this->m_index();exit;
            } else if( ACTION_NAME=='show' ) {
				$maction->goodInfo($_GET['id']); //产品详情
                $this->m_show();exit;
            }
        }*/
        if( !method_exists($this, ACTION_NAME) ) {
        	$this->display('index');exit;
        }
    }
    
    public function show() {
    	$this->display();
    }
    
    
    /**********************************手机************************************/
    
    public function m_index() {
        $this->display($this->mobile_theme.':Goods:index');
    }
    
    public function m_show() {
		 $this->display($this->mobile_theme.':Goods:show');
    }
    
    //添加产品资讯
    public function m_addInquire() {
    	$giDao = M('GoodsInquire');
    	$_POST['create_time'] = time();
    	if( $giDao->add($_POST)!==false ) {
    		exit('success');
    	} else {
    		exit('error');
    	}
    }

}
?>