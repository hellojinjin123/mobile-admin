<?php
class MobileAction extends CommonAction{
	
	function _initialize() {
		parent::_initialize();
		$this->assign('actionName',MODULE_NAME);
		$this->getSystem();
	}
	
	function getSystem(){
		
		$system = M('System')->find();
		
		$this->assign('system',$system);
	}
	
	protected function m_page($where, $rowpage = 10, $sortBy = '', $asc = false) {
	
			//排序字段 默认为主键名
			if (isset($_REQUEST ['_order'])) {
				$order = $_REQUEST ['_order'];
			} else {
				$order = !empty($sortBy) ? $sortBy : $this->modelDao->getPk();
			}
			//排序方式默认按照倒序排列
			//接受 sost参数 0 表示倒序 非0都 表示正序
			if (isset($_REQUEST ['_sort'])) {
				$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
			} else {
				$sort = $asc ? 'asc' : 'desc';
			}
				
			/*分页*/
			import ( "ORG.Util.Page" );
			$count = $this->modelDao->where ( $where )->count ();
			$page = new Page ( $count, $rowpage );
			$dataList = $this->modelDao->where ( $where )->order("`" . $order . "` " . $sort)->limit ( $page->firstRow . ',' . $page->listRows )->select ();
			//echo $this->modelDao->getlastsql();
			/*在URL添加参数*/
			foreach ( $where as $key => $val ) {
				if (!is_array($val)) {
					$p->parameter .= "$key=" . urlencode($val) . "&";
				}
			}
			//$page->setConfig ( "theme", "%first% %upPage% %linkPage% %downPage% %end%" );
			$pageBar = $page->m_show ();
			$sort = $sort == 'desc' ? 1 : 0; //排序方式
			$this->assign ( 'pageBar', $pageBar );
			$this->assign ( 'sort', $sort);
			$this->assign ( 'totalRows', $count );
			$this->assign ( 'rowpage', $rowpage );
			return array('data'=>$dataList,'pagenav'=>$pageBar);
	}
		
}

?>