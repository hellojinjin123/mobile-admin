<?php

class HomeAction extends CommonAction
{
	public $is_mobile = false;
	
	public $mobile_theme = '';
	
	public $system = null;

	function _initialize() {
		parent::_initialize();
		$this->getPartList();
		import('ORG.Util.MobileDetect');
		$detect = new MobileDetect();
		
		$systemDao = M('System');
		$domainDao = M('Domain');
		$domainInfo = $domainDao->where('target != \'PC\'')->select();
		for($i = 0 ; $i<count($domainInfo);$i++)
		{
			$domain .= $domainInfo[$i]['domain_name'].',';	
		}
		$domainInfoPC = $domainDao->where('target = \'PC\'')->select();
		for($i = 0 ; $i<count($domainInfo);$i++)
		{
			$domainPC .= $domainInfoPC[$i]['domain_name'].',';	
		}
		//dump($domainInfoPC);
		//$domain = $systemDao->where( array('lang'=>'mobile') )->getField('domain');
		
		if( strpos($domain,$_SERVER["HTTP_HOST"])!==false ) {//设置手机域名
			$this->is_mobile = true;
			$this->mobileConfig($detect,$systemDao);
		} else if(strpos($domainPC,$_SERVER["HTTP_HOST"])!==false){
			$this->is_mobile = false;
			$this->mobileConfig($detect,$systemDao);
		} 
		elseif( $detect->isMobile()==true ) {
					//	echo 'asd';
			$this->is_mobile = $detect->isMobile();
			$this->mobileConfig($detect,$systemDao);
		} else {
			$this->assignSystem($systemDao);
		}
	}
	
	public function mobileConfig($detect,$systemDao) {
		//$this->assignSystem($systemDao,'mobile');
		$this->assignSystem($systemDao,L('language'));
	}

	//获取网站信息
	public function assignSystem($systemDao, $lang ) {
		if( empty($lang) ) {
			$lang = L('language'); //获取当前语言
		}
		$this->system = $systemDao->where( array('lang'=>$lang) )->find();
		$this->mobile_theme = $this->system['mobile_theme'];
		$this->assign('public_mobile', __ROOT__.'/'.APP_NAME.'/Tpl/default/'.$this->mobile_theme.'/Public');
		$this->assign('mobile_theme', $this->mobile_theme);
		$this->assign('system', $this->system);
	}

   /**
    * 文件下载
    */
	public function down() {
		$downloadDao = M('Download');
		$id = $_GET['id'];
			
		if( !empty($id) ) {
			$download = $downloadDao->find($id);
		} else {
			$this->error('找不到文件');
		}
		$file_name=$download['downfile'];
		$explode = explode('.',$file_name);
		$file_title  = $download['title'].'.'.$explode[1];
		if( !empty($file_name) ) {
			header("Content-type:text/html;charset=utf-8");
			
			//用以解决中文不能显示出来的问题
			$file_name=iconv("utf-8","gb2312",$file_name);
			$file_sub_path=$_SERVER['DOCUMENT_ROOT'].__ROOT__.'/Public/data/upload/images/download/'; 
			$file_path=$file_sub_path.$file_name;
			//首先要判断给定的文件存在与否
			if(!file_exists($file_path)){
				$this->error('找不到文件');
			}
			$fp=fopen($file_path,"r");
			$file_size=filesize($file_path);
			//下载文件需要用到的头
			Header("Content-type: application/octet-stream");
			Header("Accept-Ranges: bytes");
			Header("Accept-Length:".$file_size);
			Header("Content-Disposition: attachment; filename=".$file_title);
			$buffer=1024;
			$file_count=0;
			//向浏览器返回数据
			while(!feof($fp) && $file_count<$file_size){
				$file_con=fread($fp,$buffer);
				$file_count+=$buffer;
				echo $file_con;
			}
			fclose($fp);
		} else {
			$this->error('找不到文件');
		}
		exit();
	}
	
	
	//发送邮件
	function sendEmail($obj) {
			import ( "ORG.Email.PHPMailer" );
			$mail = new PHPMailer ();
	
			$mail->CharSet = "utf-8";
			$mail->Encoding = "base64";
			$mail->Host       = $host['email_smtp_host'];
			//$mail->SMTPDebug = 1;
			$mail->IsSMTP ();
			$mail->Host = $obj['email_smtp_host'];
			$mail->SMTPAuth = true;
	//		$mail->SMTPSecure = 'ssl';
			if(!empty($obj['email_smtp_port'])){
				$mail->Port = $obj['email_smtp_port'];
			}
			$mail->Username = $obj['email_username'];
			$mail->Password = $obj['email_password'];
			$mail->SetFrom ( $obj['email_address'], $obj['email_auto'] );
			$mail->AddReplyTo ( $obj['email_address'], $obj['email_auto'] );
			$mail->Subject = $obj['email_subject'];
			 
			$mail->MsgHTML ( $obj['body'] );
			$mail->AddAddress ( $obj['user_email'], $obj ["user_email"] );
			return $mail->Send ();
		}


	/**
	 +----------------------------------------------------------
	 * 产生随机字串，可用来自动生成密码 默认长度6位 字母和数字混合
	 +----------------------------------------------------------
	 * @param string $len 长度
	 * @param string $type 字串类型
	 * 0 字母 1 数字 其它 混合
	 * @param string $addChars 额外字符
	 +----------------------------------------------------------
	 * @return string
	 +----------------------------------------------------------
	 */
	function rand_string($len=6,$type='',$addChars='') {
	    $str ='';
	    switch($type) {
	        case 0:
	            $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.$addChars;
	            break;
	        case 1:
	            $chars= str_repeat('0123456789',3);
	            break;
	        case 2:
	            $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ'.$addChars;
	            break;
	        case 3:
	            $chars='abcdefghijklmnopqrstuvwxyz'.$addChars;
	            break;
	        case 4:
	            $chars = "们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均药标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占死毒圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距触星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒杀汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷枪黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒茎男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭骗休借".$addChars;
	            break;
	        default :
	            // 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
	            $chars='ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789'.$addChars;
	            break;
	    }
	    if($len>10 ) {//位数过长重复字符串一定次数
	        $chars= $type==1? str_repeat($chars,$len) : str_repeat($chars,5);
	    }
	    if($type!=4) {
	        $chars   =   str_shuffle($chars);
	        $str     =   substr($chars,0,$len);
	    }else{
	        // 中文随机字
	        for($i=0;$i<$len;$i++){
	          $str.= msubstr($chars, floor(mt_rand(0,mb_strlen($chars,'utf-8')-1)),1);
	        }
	    }
	    return $str;
	}
	//获取后缀
	public function getSuffix($file_name)
	{
		$extend =explode("." , $file_name);
		$va=count($extend)-1;
		return $extend[$va];
	}
	//播放视频
	public function videoShow(){
		//判断是否为IOS
		import ( "ORG.Util.MobileDetect" );
		$detect = new MobileDetect();
		$db = M('Video');
		$re = $db->where(array('is_show' => 1,'is_publish' => 1))->find();
		$suffix = $this->getSuffix($re['downfile']);
		$re['suffix'] = $suffix;
		//改变视频播放
		if($detect->isiOS()){
			if($re['y_or_t'] == 0) //调用优酷
			{
				preg_match('[(sid\/)(.*)(/v)]', $re['url'], $arr);	//截取字符串的某个部分
				$getId = $arr[2];
				$re['url'] = '<video width="'.$re['vWidth'].'" height="'.$re['vHeight'].'" controls="controls" src="http://v.youku.com/player/getRealM3U8/vid/'.$getId.'/type//video.m3u8"></video>';
			}else	//土豆
			{
				preg_match('[(v\/)(.*)(\/\&)]', $re['url'], $arr);	//截取字符串的某个部分
				$getId = $arr[2];
				if($getId == '')
				{
					
					preg_match('[(l\/)(.*)(\/\&)]', $re['url'], $arr);	//截取字符串的某个部分
					$getId = $arr[2];
				}
				$re['url'] = '<iframe width="'.$re['vWidth'].'" height="'.$re['vHeight'].'" frameborder="0" src="http://www.tudou.com/programs/view/html5embed.action?code='.$getId.'"></iframe>';
			}
		}
		$this->assign('result',$re);
	}
	//自定义栏目
	public function getPartList(){
		$partDao = M('Part');
		import ( "ORG.Util.MobileDetect" );
		$detect = new MobileDetect();
		if(!$detect->isMobile()){
			$part = $partDao->where(array('lang'=>  L('Language') ,'is_publish'=>'1','pid'=>0))->order('orderNum desc')->select();
		}else{
			$part = $partDao->where(array('lang'=>  'mobile' ,'is_publish'=>'1'))->order('orderNum desc')->select();
			}
		for($i=0 ;$i<count($part) ;$i++ ){
			$getNext = $partDao->where(array('pid'=>$part[$i]['id'],'is_publish' => 1))->order('orderNum desc')->select();
			$part[$i]['next'] = $getNext;
		}
		for($i=0 ; $i<count($part);$i++){
			if(!$part[$i]['nowModule']){
				$part[$i]['now'] = str_replace("__APP__","",$part[$i]['url']);
			}else{
				$part[$i]['now'] = '/'.$part[$i]['nowModule'];
			}
		}
		if(MODULE_NAME == 'Index'){	//设置当前
			$now = '';
		}else{
			$now = '/'.MODULE_NAME;
		}
		$this->assign('now',$now);
		$this->assign('part',$part);
	}
}
?>