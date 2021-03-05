<?php

/**
 *
 * 手机模式设置
 * @author uclnn
 *
 */
class MobileAction extends AdminAction
{

    function _initialize ()
    {
        parent::_initialize();
    }

    public function index ()
    {
        $this->display();
    }
    
	
	
    //手机网站信息
    public function website() {
    	$this->setModel('SystemMobile');
    	$categoryDao = D('Admin.Category');
    	$this->_dataPage($categoryDao, 35, $where);
    	$this->display ('Mobile/website');
    }
    
    //编辑手机网站信息
    public function websiteEdit() {
    	$this->display('Mobile/website_edit');
    }

    public function websiteAdd(){
    	$this->setModel('SystemMobile');
    	$this->_add2($_POST);
    }
    
    public function websiteUpdate(){
    	$this->setModel('SystemMobile');
    	$this->_update2($_POST);
    }
    
    public function isPublish() {
    	$this->_updateField('is_publish');
    }
    
    public function isHome() {
    	$this->_updateField('is_home');
    }
    function deleteDomain(){
		$db = M('domain');
		try{
			if($db->where('id ='.$_GET['id'])->delete())
			{
				$this->success ( '删除成功！' );
			}else
			{
				$this->error ( '可能网络原因导致添加失败，请重试' );
			}
		}catch( Exception $e)
		{
			$this->error('异常：'.$e->getMessage() );
		}
	}

	function edit_domain(){
		$this->assign('info',$this->showDomain($_GET['id']));
		//dump($this->showDomain($_GET['id']));
		$this->display();
	}
	public	function showDomain($id){
		$db = M('domain');
		$result = $db->where('id ='.$id)->find();
		return $result;
	}
	function saveDomain(){
		$db = M('domain');
		if(!$_POST['id'])
		{
			try{
				$bool = $db->add($_POST);
				if($bool!==false)
				{
					$this->success ( '添加成功！' );
				}else {
					$this->error ( '可能网络原因导致添加失败，请重试' );
				}

			}catch ( Exception $e){
				$this->error('异常：'.$e->getMessage() );
			};
		}else
		{	$bool = $db->where('id ='.$_POST['id'])->save($_POST);
		if($bool!==false)
		{
			$this->success ( '修改成功！' );
		}else
		{dump($db->getLastSql());
		$this->error ( '可能网络原因导致添加失败，请重试' );
		}
		}
	}

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    public function ajaxtree () {
        $def_lang = $this->custom['def_lang'];
        $id = $_POST["id"];
        $value = $_POST['value'];
        $categoryDao = M('Category');
        
        if( $value=='root' ) {
            $categoryList = $categoryDao->where(array('is_mobile'=>1,'pid'=>12,'id'=>array('in',$this->custom['modules'])))->select();
        } else {
            $categoryList = $categoryDao->where(array('pid'=>$id,'is_publish'=>1,'is_fixed'=>0,'lang'=>$def_lang))->select();
        }
        foreach ($categoryList as $key=>$value) {
            $child_count = $categoryDao->where(array('pid'=>$value['id'],'is_publish'=>1,'is_fixed'=>0,'lang'=>$def_lang))->count();
            if( $child_count > 0 ) {
                $hasChildren = true;
            } else {
                $hasChildren = false;
            }
            $is_mobile = $categoryDao->getField('is_mobile',array('id'=>$value['id']));
            $ret[] = array(
                    "id" => $value['id'],
                    "text" => $value['title'],
                    "value" => $value['id'],
                    "showcheck" => true,
                    "complete" => false,
                    "isexpand" => false,
                    "checkstate" => $is_mobile,
                    "hasChildren" => $hasChildren
            );
        }
        header('Content-type:text/javascript;charset=UTF-8');
        exit(json_encode($ret));
    }
    
    //设置手机显示
    public function isMobile() {
        $categoryDao = D('Admin.Category');
        $id = $_GET['id'];
        $levels = $categoryDao->getUpLevels($id);
        $checkstate = $_GET['checkstate'];
        $categoryDao->where(array('id'=>array('in',str_replace('|', ',', $levels))))->setField('is_mobile', 1);
        $result = $categoryDao->where(array('id'=>$id))->setField('is_mobile', $checkstate==0?1:0);
        exit($result);
    }
    
}
?>