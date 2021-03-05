<?php

/**
 * 
 * 后台主框架控制器
 * @author uclnn
 *
 */
class IndexAction extends AdminAction {

	
	public function index() {
		
		$this->_assignModuleList();
		
		$this->display ( 'Layout:admin' );
	}

	//系统首页
	public function main() {
		$newsDao = M('News');
		$goodsDao = M('Goods');
		$guestbookDao = M('Guestbook');
		$advertDao = M('Advert');
		$linkDao = M('Link');
		$downloadDao = M('Download');
		$jobDao = M('Job');
		$jobrDao = M('JobResume');
		$memberDao = M('Member');
		$customDao = M('Custom');
		
		$this->assign('newsCount', $newsDao->count());
		$this->assign('goodsCount', $goodsDao->count());
		$this->assign('guestbookCount', $guestbookDao->count());
		$this->assign('guestbookCountRead0', $guestbookDao->where(array('read'=>0))->count());
		$this->assign('advertCount', $advertDao->count());
		$this->assign('linkCount', $linkDao->count());
		$this->assign('downloadCount', $downloadDao->count());
		$this->assign('jobCount', $jobDao->count());
		$this->assign('jobrCount', $jobrDao->count());
		$this->assign('memberCount', $memberDao->count());
		$this->assign('todayMemberCount', $memberDao->where("(FROM_UNIXTIME(create_time,'%Y-%m-%d')='" . date ( 'Y-m-d', time () ) . "')")->count());
		$this->assign('custom', $customDao->find(1));
		
		$this->_assignModuleList();
		$this->assign('default_group',C('DEFAULT_GROUP'));
		$this->display ();
	}
	
	public function mainMenu() {
		exit;
	}

	public function category() {
		$this->assign('c_root', $_GET['c_root']);
		$this->display ();
	}

	//菜单
	public function sidemenu() {
		$mid = $_GET['mid'];
		if( !empty( $mid ) ) {
			$categoryDao = M('Categorys');
			$data['m_categorys.fid'] = 1;
			$data['m_categorys.model_id'] = $mid;
			$dataList = $categoryDao->join('m_modelconfig on(m_modelconfig.id=m_categorys.model_id)')->where( $data )->field('m_categorys.*,m_modelconfig.modelaction')->order('m_categorys.id asc')->select();
								
			$this->assign('dataList', $dataList);
			$this->assign('mid',$mid);
		}
				
		$this->display ();
	}
	
	//改变当前语 言
	public function checkedLang() {
		$lang = $_GET['lang'];
		if($lang=='all') {
			$_SESSION[C('USER_AUTH_KEY')]['lang'] = $this->custom['def_lang'];
		} else {
			$_SESSION[C('USER_AUTH_KEY')]['lang'] = $lang;
		}
		
	}
	
	//获取单个分类信息
	public function getCategory() {
		$id = $_REQUEST['id'];
		if( !empty($id) ) {
			$categoryDao = M('Category');
			$category = $categoryDao->find($id);
			if ( $this->isAjax() ) {
				exit(json_encode($category));
			} else {
				$this->assign('obj',$category);
			}
		}
	}
	
	//传入Pid找下级分类
	function selectCategoryByPid() {
		
		
		$mid = $_GET ["mid"];
		$categoryDao = M ( "Categorys" );
		$categoryList = $categoryDao->where ( array('model_id'=>$mid,'fid'=>1,'tpl_one'=>array('neq','one')) )->order('id asc')->select ();
		if( $this->isAjax() ) {
			$json ['list'] = $categoryList;
			exit(json_encode ( $json ));
		} else {
			$this->assign('categoryList', $categoryList);
		}
	}
	
	function getslaveCategory(){
		
		$fid = $_GET ["fid"];
		$categoryDao = M ( "Categorys" );
		$categoryList = $categoryDao->where ( array('fid'=>$fid,'tpl_one'=>array('neq','one')) )->order('id asc')->select ();
		
		if( $this->isAjax() ) {
			if($categoryList){
				$json ['list'] = $categoryList;
				$json['loop'] = 1;
			}else{
				$json['loop'] = 0;
			}
			exit(json_encode ( $json ));
		} else {
			$this->assign('categoryList', $categoryList);
		}
	}
}
?>