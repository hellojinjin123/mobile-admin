<?php

class AdminAction extends CommonAction {

	protected $lang;//当前语言

	protected $c_root;//当前模块分类根ID

	protected $custom;//定制配置

	protected $admin; //管理员信息

	protected $access ; //用户权限	
		 
	
	function _initialize() {
		parent::_initialize ();

		//登录与权限检查
		if (!$_SESSION [C('USER_AUTH_KEY')]) {
			
			$this->redirect('Login/index');
		} else {
			
			$this->admin = $_SESSION[C('USER_AUTH_KEY')];

			if( !$this->admin['superadmin'] ) {//不是超级管理员
				$this->access = $_SESSION['access'][MODULE_NAME];				
			}

		}
		
		$this->assign('actionName', MODULE_NAME);
	}

	protected function pagewhere($cid){
		
		if($this->admin['superadmin']){
			
			return $where = array('_string'=>"category_id like '$cid%'");
		}else{
			if(empty($_GET['cid'])){					
				return $where = array('category_id'=>array('in',implode(',',$this->access)));
			}else{						
				$category = M('Categorys')->where('id='.$cid)->find();
				if($category['is_child']==0){								
					return $where = array('_string'=>"category_id like '$cid%'");					
				}elseif($category['is_child']>0){
					
					$slavecategory = M('Categorys')->where('fid='.$cid)->field('id')->select();					
					foreach($slavecategory as $value){
						if(in_array($value['id'],$this->access)){							
							$category2 = M('Categorys')->where('id='.$value['id'])->find();
							if($category2['is_child']==0){								
								$res[] = $value['id'];
							}else{
								$res[] = $value['id'];
								$res[] = $this->checkSlaveCate($value['id']);
							}							
						}
					}
					$res[] = $cid;									
					return $where = array('category_id'=>array('in',implode(',',$res)));
					
				}
			}
			
		}
	}
	
	function checkSlaveCate($id){
		$category = M('Categorys')->where('fid='.$id)->field('id')->select();
		foreach($category as $val){
			if(in_array($val['id'],$this->access)){
				$category2 = M('Categorys')->where('id='.$val['id'])->find();
				if($category2['is_child']==0){
					return $val['id'];
				}else{
					$res[] = $val['id'];
					$res[] = $this->checkSlaveCate($val['id']);
					return $res;
				}
			}		
		}
	}
	
	// 文件上传
	protected function _upload($uploaddir='') {
		import("ORG.Util.UploadFile");
		//导入上传类
		$upload = new UploadFile();
		//设置上传文件大小
		$upload->maxSize = 3292200;
		//设置上传文件类型
		$upload->allowExts = explode(',', 'jpg,gif,png,jpeg');
		//设置附件上传目录
		$upload->savePath = $uploaddir;
		//设置需要生成缩略图，仅对图像文件有效
		$upload->thumb = true;
		// 设置引用图片类库包路径
		$upload->imageClassPath = 'ORG.Util.Image';
		//设置需要生成缩略图的文件后缀
		$upload->thumbPrefix = 'm_,s_';  //生产2张缩略图
		//设置缩略图最大宽度
		$upload->thumbMaxWidth = '400,100';
		//设置缩略图最大高度
		$upload->thumbMaxHeight = '400,100';
		//设置上传文件规则
		$upload->saveRule = uniqid;
		//删除原图
		$upload->thumbRemoveOrigin = true;
		if (!$upload->upload()) {
			//捕获上传异常
			$this->error($upload->getErrorMsg());
		} else {
			//取得成功上传的文件信息
			$uploadList = $upload->getUploadFileInfo();
			import("@.ORG.Image");
			//给m_缩略图添加水印, Image::water('原文件名','水印图片地址')
			Image::water($uploadList[0]['savepath'] . 'm_' . $uploadList[0]['savename'], '/ThinkPHP_2.2_Full/Examples/File/Tpl/default/Public/Images/logo2.png');
			$_POST['image'] = $uploadList[0]['savename'];
		}

	}

	// SWF文件上传
	protected function _swf_upload($uploaddir='', $field='flash') {
		import("ORG.Util.UploadFile");
		$upload = new UploadFile();
		$upload->maxSize = 3292200;
		$upload->allowExts = explode(',', 'swf,');
		$upload->savePath = $uploaddir;
		$upload->saveRule = uniqid;
		if (!$upload->upload()) {
			$this->error($upload->getErrorMsg());
		} else {
			$uploadList = $upload->getUploadFileInfo();
			$_POST[$field] = $uploadList[0]['savename'];
		}

	}

	// 图片上传
	protected function _img_upload($uploaddir='',$field='image',$thumb=true,$width=100,$height=100) {
		import("ORG.Util.UploadFile");
		$upload = new UploadFile();
		$upload->maxSize = 3292200;
		$upload->allowExts = explode(',', 'jpg,gif,png,jpeg');
		$upload->savePath = $uploaddir;
		if( $thumb==true ) {
			$upload->thumb = true;
			$upload->imageClassPath = 'ORG.Util.Image';
			$upload->thumbPrefix = 'm_,s_';
			$upload->thumbMaxWidth = '2000,'.$width;
			$upload->thumbMaxHeight = '2000,'.$height;
			$upload->thumbRemoveOrigin = true;
		}
		$upload->saveRule = uniqid;
		if (!$upload->upload()) {
			$this->error($upload->getErrorMsg());
		} else {
			$uploadList = $upload->getUploadFileInfo();
			//import("@.ORG.Image");
			//给m_缩略图添加水印, Image::water('原文件名','水印图片地址')
			//Image::water($uploadList[0]['savepath'] . 'm_' . $uploadList[0]['savename'], '/ThinkPHP_2.2_Full/Examples/File/Tpl/default/Public/Images/logo2.png');
			$_POST[$field] = $uploadList[0]['savename'];
		}

	}

	// SWF或图片文件上传
	protected function _swf_img_upload($uploaddir='', $field='flash_img') {
		import("ORG.Util.UploadFile");
		$upload = new UploadFile();
		$upload->maxSize = 3292200;
		$upload->allowExts = explode(',', 'swf,jpg,gif,png,jpeg');
		$upload->savePath = $uploaddir;
		$upload->saveRule = uniqid;
		if (!$upload->upload()) {
			$this->error($upload->getErrorMsg());
		} else {
			$uploadList = $upload->getUploadFileInfo();
			$i=1;
			foreach ($uploadList as $key => $value) {
				$_POST[$field.$i] = $value['savename'];
				$i++;
			}
		}

	}

	//批量上传
	function _upload2($dir=''){
			
		// Code for Session Cookie workaround
		if (isset($_POST["PHPSESSID"])) {
			session_id($_POST["PHPSESSID"]);
		} else if (isset($_GET["PHPSESSID"])) {
			session_id($_GET["PHPSESSID"]);
		}

		session_start();

		// Check post_max_size (http://us3.php.net/manual/en/features.file-upload.php#73762)
		$POST_MAX_SIZE = ini_get('post_max_size');
		$unit = strtoupper(substr($POST_MAX_SIZE, -1));
		$multiplier = ($unit == 'M' ? 1048576 : ($unit == 'K' ? 1024 : ($unit == 'G' ? 1073741824 : 1)));

		/*if ((int)$_SERVER['CONTENT_LENGTH'] > $multiplier*(int)$POST_MAX_SIZE && $POST_MAX_SIZE) {
		 header("HTTP/1.1 500 Internal Server Error");
		echo "error: 上传的文件过大";
		exit(0);
		}*/
		
		// Settings
		$save_path = $dir;				// The path were we will save the file (getcwd() may not be reliable and should be tested in your environment)
		$upload_name = "Filedata";
		$max_file_size_in_bytes = 2147483647;				// 2GB in bytes
		$extension_whitelist = array("doc", "txt", "jpg", "gif", "png","zip","rar",'flv');	// Allowed file extensions
		$valid_chars_regex = '.A-Z0-9_ !@#$%^&()+={}\[\]\',~`-';				// Characters allowed in the file name (in a Regular Expression format)
			
		// Other variables
		$MAX_FILENAME_LENGTH = 260;
		$file_name = "";
		$file_extension = "";
		$uploadErrors = array(
				0=>"文件上传成功",
				1=>"上传的文件超过了 php.ini 文件中的 upload_max_filesize directive 里的设置",
				2=>"上传的文件超过了 HTML form 文件中的 MAX_FILE_SIZE directive 里的设置",
				3=>"上传的文件仅为部分文件",
				4=>"没有文件上传",
				6=>"缺少临时文件夹"
		);

		
		// Validate the upload
		if (!isset($_FILES[$upload_name])) {
			$this->HandleError(":error:No upload found in \$_FILES for " . $upload_name);
			exit(0);
		} else if (isset($_FILES[$upload_name]["error"]) && $_FILES[$upload_name]["error"] != 0) {
			$this->HandleError($uploadErrors[$_FILES[$upload_name]["error"]]);
			exit(0);
		} else if (!isset($_FILES[$upload_name]["tmp_name"]) || !@is_uploaded_file($_FILES[$upload_name]["tmp_name"])) {
			$this->HandleError(":error:Upload failed is_uploaded_file test.");
			exit(0);
		} else if (!isset($_FILES[$upload_name]['name'])) {
			$this->HandleError(":error:File has no name.");
			exit(0);
		}
			
		// Validate the file size (Warning: the largest files supported by this code is 2GB)
		$file_size = @filesize($_FILES[$upload_name]["tmp_name"]);
		if (!$file_size || $file_size > $max_file_size_in_bytes) {
			//HandleError("File exceeds the maximum allowed size");
			$this->HandleError ( ':error:File exceeds the maximum allowed size');
			exit(0);
		}
		
		if ($file_size <= 0) {
			//HandleError("File size outside allowed lower bound");
			$this->HandleError ( ':error:File size outside allowed lower bound');
			exit(0);
		}
	
		// Validate file name (for our purposes we'll just remove invalid characters)
		$file_name = preg_replace('/[^'.$valid_chars_regex.']|\.+$/i', "", basename($_FILES[$upload_name]['name']));
		if (strlen($file_name) == 0 || strlen($file_name) > $MAX_FILENAME_LENGTH) {
			$this->HandleError(":error:Invalid file name");
			exit(0);
		}


		// Validate that we won't over-write an existing file
		if (file_exists($save_path . $file_name)) {

			$this->HandleError ( ':error:File with this name already exists');
			exit(0);
		}

		// Validate file extension
		$path_info = pathinfo($_FILES[$upload_name]['name']);
		$file_extension = $path_info["extension"];
		//$is_valid_extension = false;
		//foreach ($extension_whitelist as $extension) {
		if (!in_array($file_extension, $extension_whitelist)) {
			//$is_valid_extension = true;
			$this->HandleError ( ':error:文件格式不正确');
			exit;
			//break;
		}
		//}
		/*if (!$is_valid_extension) {

		$this->error ( '异常：Invalid file extension');
		exit(0);
		}*/
		
		$strNewName = rand(10,100).date("YmdHis").'.'.$file_extension;
		if (!@move_uploaded_file($_FILES[$upload_name]["tmp_name"], $save_path.$strNewName)) {
			 
			$this->HandleError ( ':error:文件无法保存.');
			exit(0);
		}
		
		// Return output to the browser (only supported by SWFUpload for Flash Player 9)
			
		//$arr = array("filename"=>$strNewName);
		echo  ":FILENAME:".$strNewName;
		exit(0);
			
	}

	function HandleError($message) {
		//header("HTTP/1.1 500 Internal Server Error");
		echo $message;
	}

	function GetVerify($length)
	{
		//'U','X','N','M','L','P','Q','B','W','G','F','A','a','b','c','d','e','f','h','i','j','k','m','n','p','r','s','t','u','v','w','x','y'
		$strings = Array('3','4','5','6','7','1','2','0','8','9','a','b','c','d','e','f','h','i','j','k','m','n','p','r','s','t','u','v','w','x','y');
		$chrNum = "";
		$count = count($strings);
		for ($i = 1; $i <= $length; $i++) {                             //循环随机取字符生成字符串
			$chrNum .= $strings[rand(0,$count-1)];
		}
		return $chrNum;
	}

	//条件列表分页
	protected function _dataPage($categoryDao, $cid, $where) {
		$lang = $_GET['lang'];
		//列表显示
		$levels = $categoryDao->getDownLevels($cid);
		if( empty($levels) ) {
			$levels = $cid;
		}
		$where['category_id'] = array('in', $levels);
		if( !empty($lang) ) {
			$where['lang'] = $lang;
		}
		$rowpage = $_REQUEST['rowpage'];
		$searchKey = $_REQUEST['searchKey'];
		if( !empty($searchKey) && $searchKey!='请输入关键字' ) {
			$where['_string'] = "title like '%$searchKey%' OR tag like '%$searchKey%'";
		}
		$rowpage = empty($rowpage)?12:$rowpage;
		$this->assign('dataList', $this->page($where, $rowpage));
		$this->assign('rowpage', $rowpage);
		$this->assign('searchKey', empty($searchKey)?'请输入关键字':$searchKey);
	}

	//条件列表分页
	protected function _dataPage2($where) {
		
		
		$rowpage = $_REQUEST['rowpage'];
		$searchKey = $_REQUEST['searchKey'];
		if( !empty($searchKey) && $searchKey!='请输入关键字' ) {
			$where['_string'] = "title like '%$searchKey%' OR tag like '%$searchKey%'";
		}
		$rowpage = empty($rowpage)?12:$rowpage;
		$this->assign('dataList', $this->page($where, $rowpage));
		$this->assign('rowpage', $rowpage);
		$this->assign('searchKey', empty($searchKey)?'请输入关键字':$searchKey);
	}
	
	
	//获取子分类的第一个分类ID并重定向
	public function goToCategoryFirst( $mid ) {
		$data['model_id'] = $mid;
		$data['fid'] = 1;
		//$data['lang'] = $this->lang;
		$categoryDao = M('Categorys');
		$obj = $categoryDao->where( $data )->order('ordernum desc')->first();
		if( empty($obj['url']) ) {
			$this->redirect(MODULE_NAME.'/index', array('cid'=>$obj['id']));
		} else {
			$this->redirect($obj['url'], array('cid'=>$obj['id']));
		}
	}

	//转到单个内容页面
	public function _oneContent($cid) {
		
		$newsDao = M('News');
		$news = $newsDao->where(array('category_id'=>$cid))->find();
		
		$this->assign('obj', $news);
		$this->assign('cid',$cid);
		$this->display ('Index/edit-one');
		exit;
	}

	//单页添加与更新
	public function _saveOne($data) {
		$newsDao = M('News');
		
		//$this->_setMyIdOnDefaultLang($data, $newsDao);
		
		//发布设置
		if (!isset($data['is_publish'])) {
			$data['is_publish'] = 0;
		}
		if( !empty($data['content']) ) {
			//HTML标签转实体
			if (get_magic_quotes_gpc ()) {
				$content = htmlspecialchars ( stripslashes ( $data ['content'] ) );
			} else {
				$content = htmlspecialchars ( $data ['content'] );
			}
			$data['content'] = $content;
		}
		$data['category_id'] = empty($data['category_id'])?$_GET['cid']:$data['category_id'];
		$count = $newsDao->where(array('category_id'=>$data['category_id']))->count();
		
		if( $count==0 ) { //添加
			unset($data['id']);
			
			$data['update_time'] = time();
			$data['create_time'] = time();
			if($newsDao->add($data)!==false) {
				
				$this->success ( '添加成功！');
			} else {
				$this->error('添加失败！');
			}
		} else { //更新
			$data['update_time'] = time();
			if($newsDao->save($data)!==false) {
				
				$this->success ( '更新成功！');
			} else {
				$this->error('更新失败！');
			}
		}
	}
	
	//处理没有添加默认语言数据,需要添加占位空数据
	protected function _setMyIdOnDefaultLang(&$data, $newsDao) {
		if( $data['lang']!=$this->custom['def_lang'] && empty($data['id']) && empty($data['my_id']) ) {
			$data_def['lang'] = $this->custom['def_lang'];
			$data_def['category_id'] = $data['category_id'];
			$data_def['update_time'] = time();
			$data_def['create_time'] = time();
			if($newsDao->add($data_def)!==false) {
				$last_id = $newsDao->getLastInsID();
				if( !empty($last_id) ) {
					$result = $newsDao->where(array('id'=>$last_id))->setField('my_id', $last_id);
					if( $result===false ) {
						$this->error('添加失败！');
					}
				} else {
					$this->error('添加失败！');
				}
				$data['my_id'] = $last_id;
			} else {
				$this->error('添加失败！');
			}
		}
	}

	//编辑页面
	protected function _edit() {
		
		$cid = $_GET['cid'];
		$categoryDao = M('Categorys');
		$tpl_one = $categoryDao->where(array('id'=>$cid))->getField('tpl_one');
		if( $tpl_one=='one' ) {
			$this->_oneContent($cid); //单页显示方式
		}

		//获取编辑数据
		$id = $_GET['id'];

		if( !empty($id) ) {
			$obj = $this->modelDao->where(array('id'=>$id))->find();
			$cid = $obj['category_id'];
		} else {
			$cid = $_GET['cid'];
		}

	
		$this->assign('obj',$obj);
		
	}

	//普通修改
	protected function _update($data) {
		try {
			//发布设置
			
			$this->modelDao->save ( $data );
			$this->success ( '修改成功！');
		} catch ( Exception $e ) {
			$this->error ( '异常：' . $e->getMessage () );
		}
	}

	//复杂修改操作，只要用在像发布新闻有分类,HTML内容处理
	protected function _update2($data) {
		try {
			$data = $this->_processData($data);			
			$result = $this->modelDao->save($data);					

			$this->assign('jumpUrl', __APP__.'/Admin/'.MODULE_NAME.'/index/cid/'.$data['category_id'].'/mid/'.$data['mid']);
			if( $result!==false ) {
				
				$this->success ( '修改成功！');
			} else {
				$this->success ( '修改失败！');
			}
		} catch ( Exception $e ) {
			$this->error ( '异常：' . $e->getMessage () );
		}
	}

	//普通添加
	protected function _add($data) {
		try {
			unset($data['id']);
			if( empty($data['lang']) ) {
				$data['lang'] = $this->custom['def_lang'];
			}
			if ($this->modelDao->add ( $data )) {

				$this->_updateMyId($data['my_id']);

				$this->success ( '添加成功！' );
			} else {
				$this->error ( '添加失败！' );
			}
		} catch ( Exception $e ) {
			$this->error ( '异常：' . $e->getMessage () );
		}
	}

	//添加复杂操作，只要用在像发布新闻有分类,HTML内容处理
	protected function _add2($data) {
		try {
			$data = $this->_processData($data);
			
			if ($this->modelDao->add ( $data )) {

				//$this->_updateCategoryListCount($data['category_id'],'','add');

				$this->assign('jumpUrl', __APP__.'/Admin/'.MODULE_NAME.'/index/cid/'.$data['category_id'].'/mid/'.$data['mid']);
				$this->success ( '添加成功！' );
			} else {
				$this->error ( '添加失败！' );
			}
		} catch ( Exception $e ) {
			$this->error ( '异常：' . $e->getMessage () );
		}
	}
	
	protected function getModileCategoryId(&$data) {
		//选择最后一个分类ID保存
		if($data['three_mobile_category_id']!=-1 && !empty($data['three_mobile_category_id'])) {
			$data['category_id'] = $data['three_mobile_category_id'];
		} else if($data['two_mobile_category_id']!=-1 && !empty($data['two_mobile_category_id'])) {
			$data['category_id'] = $data['two_mobile_category_id'];
		} else {
			$data['category_id'] = $data['one_mobile_category_id'];
		}
	}

	protected function _updateMyId( $my_id ) {
		$last_id = $this->modelDao->getLastInsID();
		if( empty($my_id) ) {
			//更新my_id
			$this->modelDao->where(array('id'=>$last_id))->setField('my_id',$last_id);
		}
		return $last_id;
	}

	/**
	 * 添加/更新/删除/移动/复制有分类文章,都需要更新当前分类下列表数量
	 *
	 * @param int $current_cid 当前分类ID
	 * @param int $before_cid 修改之前分类ID, 只用在修改或移动时改变分类使用
	 * @param string $act 执行数据库动作
	 */
	protected function _updateCategoryListCount( $current_cid, $before_cid, $act='add' ) {
		$categoryDao = D('Admin.Category');
		$levels = $categoryDao->getUpLevels( $current_cid );
		$levels = explode('|', $levels);
		$levels[] = $current_cid;

		if( $act=='add' ) {//添加需要累加数量
			foreach ($levels as $key => $value) {
				$categoryDao->setInc("list_count","id=$value",1);
			}
		} else if( $act=='update' ) {//如更改分类需要减去和累加数量

			if( $before_cid!=$current_cid ) {//判断修改了分类
				//当前分类累加
				foreach ($levels as $key => $value) {
					$categoryDao->setInc("list_count","id=$value",1);
				}

				//之前分类减去
				$before_levels = $categoryDao->getUpLevels( $before_cid );
				$before_levels = explode('|', $before_levels);
				$before_levels[] = $before_cid;
				foreach ($before_levels as $key => $value) {
					$categoryDao->setDec("list_count","id=$value",1);
				}

			}
		} else if( $act=='delete' ) {//删除需要减去数量
			foreach ($levels as $key => $value) {
				$categoryDao->setDec("list_count","id=$value",1);
			}
		}

	}

	//加工处理分类,HTML内容处理等
	protected function _processData($data) {

		//选择最后一个分类ID保存
		if($data['three_category_id']!=-1 && !empty($data['three_category_id'])) {
			$data['category_id'] = $data['three_category_id'];
		} else if($data['two_category_id']!=-1 && !empty($data['two_category_id'])) {
			$data['category_id'] = $data['two_category_id'];
		} else {
			$data['category_id'] = $data['one_category_id'];
		}

		if($data['category_id']==-1) {
			$this->error('请选择分类！');
		}

		if( !empty($data['content']) ) {
			//HTML标签转实体
			if (get_magic_quotes_gpc ()) {
				$content = htmlspecialchars ( stripslashes ( $data ["content"] ) );
			} else {
				$content = htmlspecialchars ( $data ["content"] );
			}
			$data['content'] = $content;
		}

		//发布设置
		if (!isset($data['is_publish'])) {
			$data['is_publish'] = 0;
		}
		

		//时间设置
		if( !empty($data['update_time']) ) {
			$data['update_time'] = strtotime($data['update_time']);
		} else {
			$data['update_time'] = time();
		}
		if( !empty($data['create_time']) ) {
			$data['create_time'] = strtotime($data['create_time']);
		} else {
			$data['create_time'] = time();
		}
		if( !empty($data['begin_time']) ) {
			$data['begin_time'] = strtotime($data['begin_time']);
		} else {
			$data['begin_time'] = time();
		}
		if( !empty($data['end_time']) ) {
			$data['end_time'] = strtotime($data['end_time']);
		} else {
			$data['end_time'] = time();
		}

		return $data;
	}

	//分类管理
	protected function _category( $where ) {
		$pid = $_GET ['pid'];
		Load ( 'extend' );
		$categoryDao = M( 'Category' );
		$where['is_fixed'] = 0;
		$where['lang'] = $this->custom['def_lang'];
		$categoryList = $categoryDao->where($where)->order('my_id asc,ordernum asc')->findAll ();
		$categoryList = list_to_tree ( $categoryList, 'id', 'pid', '_child', $pid );
		$this->assign ( 'categoryList', $categoryList );
		$this->display ('Category/index');
	}

	//多选删除
	protected function _delete() {
		try {
			$ids = $_POST ["ids"];
			
			$numAndId = implode( ',', $ids);
			$where['id']  = array('in',$numAndId);
			
			$this->modelDao->where($where)->delete();	
			$this->assign('jumpUrl', __APP__.'/Admin/'.MODULE_NAME.'/index/mid/'.$_POST['mid']);
			$this->success ( '删除成功！' );
		} catch ( Exception $e ) {
			$this->error ( '异常：' . $e->getMessage () );
		}
	}

	//单个删除
	protected function _deleteById() {
		try {			
			$this->modelDao->delete ( $_GET ['id'] );
			$this->assign('jumpUrl', __APP__.'/Admin/'.MODULE_NAME.'/index/mid/'.$_GET['mid']);			
			$this->success ( '删除成功！' );
		} catch ( Exception $e ) {
			$this->error ( '异常：' . $e->getMessage () );
		}
	}

	//移动
	protected function _move($field='category_id') {
		try {
			$ids = $_POST ['ids'];
			
			if (! empty ( $ids )) {				
				$category_id = $this->_getCategoryId();
				$numAndId = implode( ',', $ids);
				$where['id']  = array('in',$numAndId);
				$res = $this->modelDao->where($where)->save(array('category_id'=>$category_id));
				
				if($res!==false){
				
					$this->success ( '移动成功！' );
				}else{
					$this->success ( '移动失败！' );
				}
			}
		} catch ( Exception $e ) {
			$this->error ( '异常：' . $e->getMessage () );
		}
	}

	//复制数据到指定分类
	protected function _copy() {
		try {
			$ids = $_POST ['ids'];
			$category_id = $this->_getCategoryId();
			
			if (! empty ( $ids )) {
				$count = count ( $ids );
				foreach($ids as $id) {
					
					$obj = $this->modelDao->where ( 'id=' . $id )->find ();
					$obj ['id'] = null;
					$obj ['category_id'] = $category_id;
					$this->modelDao->add ( $obj );
										
				}
			}
			
			$this->success ( '复制成功！' );
		} catch ( Exception $e ) {
			$this->error ( '异常：' . $e->getMessage () );
		}
	}

	//选择最后一个分类ID保存
	private function _getCategoryId() {

		if(!empty($_POST['three_category_id'])) {
			$category_id = $_POST['three_category_id'];
		} else if(!empty($_POST['two_category_id'])) {
			$category_id = $_POST['two_category_id'];
		} else {
			$category_id = $_POST['one_category_id'];
		}
		return $category_id;
	}

	//多选更新排序
	protected function _ordernum() {
		try {
			$ordernums = $_POST ['ordernums'];
			$ids = $_POST ['ids'];
			if (! empty ( $ordernums ) && ! empty ( $ids )) {
				$count = count ( $ids );
				for($i = 0; $i < $count; $i ++) {
					$numAndId = explode ( ',', $ids [$i] );
					$bool = $this->modelDao->setField ( 'ordernum', $ordernums [$numAndId [0] - 1], 'id=' . $numAndId [1] );
				}
			}
			$this->success ( '更新成功！' );
		} catch ( Exception $e ) {
			$this->error ( '异常：' . $e->getMessage () );
		}
	}

	//更新单个字段
	protected function _updateField($filed){
		$fval = $_GET['fval'];
		if($fval=='true') {
			$fval = 1;
		} else {
			$fval = 0;
		}
		echo $this->modelDao->setField ( $filed, $fval, array('id'=>$_GET['id']) );
	}

	//可设置图片大小添加、更新上传通用
	protected function _imgUploads($folder) {
		$dir = C('UPLOAD_FILE_RULE').'images/'.$folder.'/';
		$imgwidth = $_POST['imgwidth'];
		$imgheight = $_POST['imgheight'];
		if( !empty($_FILES['image']['name']) && !empty( $imgwidth ) && !empty( $imgheight ) ) {
			$this->_img_upload($dir,'image',true,$imgwidth,$imgheight);
		} elseif( !empty($_FILES['image']['name'] )) {
			$this->_img_upload($dir,'image');
		}
	}

	//删除图片
	protected function _deleteImage( $path ) {
		$where['id'] = $_GET['id'];
		$filename = $this->modelDao->where($where)->getField('image');
		unlink($path.$filename);
		unlink($path.'s_'.$filename);
		unlink($path.'m_'.$filename);
		$bool = $this->modelDao->where($where)->setField('image','');
		if( $bool!==false ) {
			return true;
		} else {
			return false;
		}
	}

	//删除文件
	protected function _deleteFile( $path ) {
		$where['id'] = $_GET['id'];
		$filename = $this->modelDao->where($where)->getField('downfile');
		unlink($path.$filename);
		$bool = $this->modelDao->where($where)->setField('image','');
		if( $bool!==false ) {
			return true;
		} else {
			return false;
		}
	}

	//已选择模块
	protected function _assignModuleList() {
		$categoryDao = M('Modelconfig');
		$moduleList = $categoryDao->where('is_sel=1')->order('id asc')->select();//选择语言
		
		$this->assign('moduleList', $moduleList);
	}

	//手机同步
	protected function _synchMobile( $id, $data=null ) {
		try {
			if( empty($id) ) {
				$id = $_GET ['id'];
			}
			if( empty($id) ) {
				$this->error('同步手机失败！');
			}
			
			if( empty($data) ) {
				$defLangObj = $this->modelDao->where ( array('id'=>$id) )->find ();
				$mobileObj = $this->modelDao->where( array('my_id'=>$defLangObj['my_id'],'lang'=>'mobile') )->find();//检查是否存在手机
			} else {
				$defLangObj = $data;
			}
			if( empty($mobileObj) ) {
				$defLangObj ['id'] = null;
				$defLangObj ['lang'] = 'mobile';
				$defLangObj ['list_count'] = 0;
				$result = $this->modelDao->add ( $defLangObj );
				if( $result!==false ) {
					$this->success('同步手机成功！');
				} else {
					$this->error('同步手机失败！');
				}
			} else {
				$defLangObj ['id'] = $mobileObj['id'];
				$defLangObj ['lang'] = 'mobile';
				$result = $this->modelDao->save ( $defLangObj );
				$this->_updateCategoryListCount($mobileObj['category_id'],'','update');
				if( $result!==false ) {
					$this->success('更新同步手机成功！');
				} else {
					$this->error('更新同步手机失败！');
				}
			}
		} catch ( Exception $e ) {
			$this->error ( '异常：' . $e->getMessage () );
		}
	}

	//没权限访问提示
	protected function _noAccess() {
		if( $this->isAjax() ) {
			exit('no-access');
		} else {
			$this->redirect('Public/no-access');
		}
	}

}
?>