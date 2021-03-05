<?php
/**
 *
 * 首页控制器
 * @author uclnn
 *
 */
class IndexAction extends HomeAction
{
	function _initialize() {
		parent::_initialize();

		/*if( $this->is_mobile==true ) {
			$maction = A("Home.Mobile");
			if( ACTION_NAME=='downLoad' ) {
				$this->m_downLoad();exit;
			}else if( ACTION_NAME=='index')
			{
				$maction->banner();
				$maction->indexGoods();
				$maction->hotAd(3);
				$this->videoShow();
				$this->m_index();exit;
			}else if ( ACTION_NAME == 'she')
			{
				$this->m_she();exit;
			}
		}*/
	}

	public function index() {
		$this->display();
	}

	public function m_index() {
		$this->assign('headTitle', $this->system['seo_title']);
		$this->display($this->mobile_theme.':Index:index');
	}
	public function m_she()
	{
		$this->assign('headTitle', $this->system['seo_title']);
		$this->display($this->mobile_theme.':Index:she');
	}
	public function m_downLoad()
	{
				$db = M('mobile_website');
				$system = M('system');
				$sysInfo = $system->where(array('lang'=> 'mobile'))->find();
				$data = $db->select();
				for($i=0;$i<count($data);$i++)
				{
					if($data[$i]['content_type'] == '')
					{
						$data[$i]['get'] = 'ADR:'.$data[$i]['content']."\n";
					}
					
					if($data[$i]['content_type'] == "email")
					{
						$data[$i]['get'] = 'EMAIL:'.$data[$i]['content']."\n";
					}
					if($data[$i]['content_type'] == "mobile")
					{
						$data[$i]['get'] = 'TEL;CELL:'.$data[$i]['content']."\n";
					}else
					{
						continue;
					}
					
					$getdata .= $data[$i]['get'];
				}
				$str='BEGIN:VCARD'."\n".'VERSION:2.1'."\n"
				.'N;CHARSET=UTF-8;ENCODING=QUOTED-PRINTABLE:'.$sysInfo['website'].';'."\n"
				.$getdata
				.'END:VCARD';
				
			//	$str = 'ssss';
			$file_name = '1.vcf';
			$file_path = realpath(dirname(__FILE__));
			//$file_path = 'public/data/'.$file_name;
			//$file_path = __ROOT__;
			$byte = file_put_contents($file_name,$str);
			//dump(file_put_contents("1.txt","HIHI"));
			/*$fp = fopen('1.txt','w+');
			fwrite('dddddddddddd',$fp);
			fclose($fp);*/
			if($byte > 0) {
				
				if(!file_exists($file_path)){
					echo $file_path;
					$this->error('找不到文件');
				}
				//$fp=fopen($file_path,"r");
				$fp=fopen($file_path,"r");
				$file_size=filesize($file_path);
				//下载文件需要用到的头
				Header("Content-type: application/octet-stream");
				Header("Accept-Ranges: bytes");
				Header("Accept-Length:".$file_size);
				Header("Content-Disposition: attachment; filename=".basename($file_name));
				readfile($file_name);
			/*	$buffer=1024;
				$file_count=0;
				//向浏览器返回数据
				while(!feof($fp) && $file_count<$file_size){
					$file_con=fread($fp,$buffer);
					$file_count+=$buffer;
					echo $file_con;
				}*/
			//	fclose($fp);
			}else
			{
				echo "网络原因导致失败";
			}
	}
	
	public function file_put_contents2($filename,$content) {
	$fp = fopen($filename,'w');
	fwrite($fp,$content);
	$suss = fclose($fp);
	if($suss)
		{
			return $content;
		}
	}
	//验证码生成
	public function verify() {
		$type = isset ( $_GET ['type'] ) ? $_GET ['type'] : 'gif';
		import ( "ORG.Util.Image" );
		Image::buildImageVerify ( 4, 1, $type );
	}
	
}
?>