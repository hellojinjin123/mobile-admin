<?php
/**
 * 
 * 控制器
 * @author uclnn
 *
 */
class MobileAction extends HomeAction
{
	function _initialize() {
    }
    
   
	//首页banner
	public function banner(){
		$advertDao = M('Advert');
		$advertHomeList = $advertDao->where(array('lang'=>'mobile','category_id'=>752))->order('ordernum desc, id desc')->select();
		if( $this->isAjax() ) {
			json_encode(array('list'=>$advertHomeList));
		} else {
			$this->assign('advertHomeList',$advertHomeList);
		}	
	}
 	//首页产品
	public function indexGoods($num){
		$goodsDao = M('Goods');
		if($num)
		{
			$goodsHomeList = $goodsDao->where(array('lang'=>'mobile','is_home'=>1))->order('ordernum desc, id desc')->limit($num)->select();
		}else
		{
			$goodsHomeList = $goodsDao->where(array('lang'=>'mobile','is_home'=>1))->order('ordernum desc, id desc')->select();
		}
		if($this->isAjax())
		{
			json_encode(array('list' => $goodsHomeList));
		}else
		{
			$this->assign('goodsHomeList',$goodsHomeList);
		}
	}
	//首页小图片
	public function hotAd($num){
		$advertDao = M('Advert');
		if($num)
		{
			$advertHomeList2 = $advertDao->where(array('lang'=>'mobile','category_id'=>684))->order('ordernum desc, id desc')->limit($num)->select();
		}else{
			$advertHomeList2 = $advertDao->where(array('lang'=>'mobile','category_id'=>684))->order('ordernum desc, id desc')->select();
		}
		if($this->isAjax())
		{
			json_encode(array('list'=>$advertHomeList2));
		}else
		{
			$this->assign('advertHomeList2',$advertHomeList2);
		}
	}
	//产品信息
	public function goodInfo($id)
	{
		 //$id = $_GET['id'];
        if( !empty( $id ) ) {
            $modelDao = M('Goods');
            $gpDao = M('GoodsPhoto');
            $categoryDao = M('Category');
            $obj = $modelDao->find( $id );
            $gpList = $gpDao->where(array('goods_id'=>$id))->select();
            $title = $categoryDao->where(array('my_id'=>$obj['category_id'],'lang'=>'mobile'))->getField('title');
			if($this->isAjax())
			{
				json_encode(array(
				'obj' => $obj,
				'gpList' => $gpList,
				'headTitle' => $obj['title'],
				'categoryTitle' => $title
				));
			}else{
            $this->assign('obj', $obj);
            $this->assign('gpList', $gpList);
            $this->assign('headTitle', $obj['title']);
			$this->assign('categoryTitle', $title);
			}
        }
	}
	//产品列表
	public function productList($cid,$page=5)
	{
		//$cid = $_REQUEST['cid'];
    	$categoryDao = D('Home.Category');
    	
    	if( empty($cid) ) {
    		$cid = $categoryDao->where( array('alias'=>'Product/index', 'is_publish'=>1, 'lang'=>'mobile') )->getField('my_id');
    	}
    	
    	$title = $categoryDao->where(array('my_id'=>$cid,'lang'=>'mobile'))->getField('title');

    	$levels = $categoryDao->getDownLevels($cid,'mobile');
    	if( empty($levels) ) {
    		$levels = $cid;
    	}
    	$where['category_id'] = array('in', $levels);
        $modelDao = M('Goods');
        $where['lang'] = 'mobile';
        $where['is_publish'] = 1;
        
        $searchKey = $_REQUEST['search_key'];
        if( $searchKey ) {//搜索关键字
        	$where['_string']="title like '%$searchKey%' OR tag like '%$searchKey%'";
        }
        /*分页*/
        import ( "ORG.Util.Page" );
        $count = $modelDao->where ( $where )->count ();
        $page = new Page ( $count, $page );
        $dataList = $modelDao->where ( $where )->order('is_top desc, ordernum desc, id desc')->limit ( $page->firstRow . ',' . $page->listRows )->select ();
         
        /*在URL添加参数*/
        foreach ( $where as $key => $val ) {
            if (!is_array($val)) {
                $p->parameter .= "$key=" . urlencode($val) . "&";
            }
        }
		if( $this->isAjax() )
		{
			json_encode(array(
				'headTitle' => $title,
				'dataList' => $dataList
			));
		}else
		{
			$page->setConfig ( "theme", "<div class=\"prevbut\">%upPage%</div> <div class=\"nextbut\">%downPage%</div> <div class=\"number\">%nowPage%/%totalPage%</div>" );
			$this->assign('headTitle', $title);
			$this->assign('dataList', $dataList);
			$this->assign ( 'pageBar', $page->show () );
		}
	}
	//新闻列表
	public function newsList($cid,$page=2)
	{
		$newsDao = M('News');
		$topList = $newsDao->where(array('lang'=>'mobile','is_publish'=>1,'is_top'=>1))->select();

		//$cid = $_REQUEST['cid'];
		$categoryDao = D('Home.Category');

		if( empty($cid) ) {
			$cid = $categoryDao->where( array('alias'=>'News/index', 'is_publish'=>1, 'lang'=>'mobile') )->getField('my_id');
		}
		$title = $categoryDao->where(array('my_id'=>$cid,'lang'=>'mobile'))->getField('title');
		
		$levels = $categoryDao->getDownLevels($cid,'mobile');
		if( empty($levels) ) {
			$levels = $cid;
		}
		$where['category_id'] = array('in', $levels);

		$where['lang'] = 'mobile';
		$where['is_publish'] = 1;
		
		/*分页*/
		import ( "ORG.Util.Page" );
		$count = $newsDao->where ( $where )->count ();
		$page = new Page ( $count, $page );
		$dataList = $newsDao->where ( $where )->order('is_top desc, ordernum desc, id desc')->limit ( $page->firstRow . ',' . $page->listRows )->select ();

		/*在URL添加参数*/
		foreach ( $where as $key => $val ) {
			if (!is_array($val)) {
				$p->parameter .= "$key=" . urlencode($val) . "&";
			}
		}
		if($this->isAjax())
		{
			json_encode(array(
			'dataList' => $dataList,
			'topList' =>$topList,
			'headTitle' => $title
			));
		}else
		{
			$page->setConfig ( "theme", "<div class=\"prevbut\">%upPage%</div> <div class=\"nextbut\">%downPage%</div> <div class=\"number\">%nowPage%/%totalPage%</div>" );
			$this->assign('dataList', $dataList);
			$this->assign('topList', $topList);
			$this->assign ( 'pageBar', $page->show () );
			$this->assign('headTitle', $title);
		}
	}
	//获取信息详情
	public function newsInfo($id)
	{
		$newsDao = M('News');
		$obj = $newsDao->where(array('id'=>$id,'lang'=>'mobile','is_publish'=>1))->find();
		if($this->isAjax())
		{
			json_encode(array(
				'obj' => $obj,
				'headTitle' => $obj['title']
			));
		}else
		{
			$this->assign('obj', $obj);
			$this->assign('headTitle', $obj['title']);
		}
	}
	//通过cid来获取信息详情
	public function cidNewsInfo($cid)
	{
		$newsDao = M('News');
		$obj = $newsDao->where(array('category_id'=>$cid,'lang'=>'mobile','is_publish'=>1))->find();
		if($this->isAjax())
		{
			json_encode(array(
				'obj' => $obj,
			));
		}else
		{
			$this->assign('obj', $obj);
			$this->assign('headTitle', $obj['title']);
		}
	}
	//获取某个分类的下级
	public function categoryList($cid)
	{
		$categoryDao = M('Category');
		$categoryList = $categoryDao->where( array('pid'=>$cid, 'is_publish'=>1, 'lang'=>'mobile') )->order('ordernum desc')->select();
		if($this->isAjax())
		{
			json_encode(array(
				'categoryList',$categoryList
			));
		}
		else
		{
			$this->assign('categoryList', $categoryList);
		}
	//	$this->assign('headTitle', '在线加盟');	
	}
	//网点信息
	public function market()
	{
		$cid = $_GET['cid'];
		$categoryDao = M('Category');
		$category = $categoryDao->where( array('alias'=>'Market/index', 'is_publish'=>1, 'lang'=>'mobile') )->find();
		$categoryList = $categoryDao->where( array('pid'=>$category['my_id'], 'is_publish'=>1, 'lang'=>'mobile') )->order('ordernum desc')->select();

		if( empty($cid) ) {//获取第一个网点数据
			$cid = $categoryList[0]['my_id'];
		}
		if($this->isAjax())
		{
			json_encode(array(
				'cid' => $cid,
				'categoryList' => $categoryList,
				'headTitle' => '服务网点'
			));
		}else
		{
			$this->assign('cid', $cid);
			$this->assign('categoryList', $categoryList);
			$this->assign('headTitle', '服务网点');
		}
	}
	//店铺形象
	public function Store(){
		$categoryDao = M('Category');
		$cid = $categoryDao->where( array('alias'=>'mobile_store', 'is_publish'=>1, 'lang'=>'mobile') )->getField('my_id');

		$advertDao = M('Advert');
		$storeList = $advertDao->where(array('category_id'=>$cid,'is_publish'=>1,'lang'=>'mobile'))->select();
		if($this->isAjax())
		{
			json_encode(array(
				'storeList' => $storeList,
			));
		}else
		{
			$this->assign('storeList', $storeList);
		}
	}
}
?>