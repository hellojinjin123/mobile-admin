<?php
/**
 * 字符串截取，支持中文和其他编码
 *
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断字符串后缀
 * @return string
 */
function str_cut($str, $start=0, $length, $suffix="",$charset="utf-8")
{
	if(function_exists("mb_substr")){
		echo mb_substr($str, $start, $length, $charset).$suffix;return;
	}
	elseif(function_exists('iconv_substr')){
		echo iconv_substr($str,$start,$length,$charset).$suffix;return;
	}
	$re['utf-8']  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
	$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
	$re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
	$re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
	preg_match_all($re[$charset], $str, $match);
	$slice = join("",array_slice($match[0], $start, $length));
	echo $slice.$suffix;
}

function striptags($str){
	return strip_tags(htmlspecialchars_decode($str));

}

/*********************************Home常用方法************************************/
/**
 * 
 * 通过ID或别名输出分类标题
 * @param int $id
 * @param string $alias
 */
function c_title( $my_id, $alias, $lang ) {
	if( empty($lang) ) {
		$lang = L('language'); //获取当前语言
	}
	$categoryDao = M('Category');
	if( !empty($my_id) ) {
		echo $categoryDao->getField('title', array('my_id'=>$my_id,'lang'=>$lang));
	} else {
		echo $categoryDao->getField('title', array('alias'=>$alias,'lang'=>$lang));
	}
}

/**
 * 可通过上级ID和别名获取分类下拉列表
 * @param int $pid
 * @param string $alias
 */
function selectCategoryOptions( $pid, $alias ) {
	$categoryDao = M('Category');
	$lang = L('language'); //获取当前语言
	if( !empty($alias) ) {
		$pid = $categoryDao->getField('my_id', array('alias'=>$alias,'lang'=>$lang));
	}
	$categoryList = $categoryDao->where(array('pid'=>$pid,'lang'=>$lang))->field('id,my_id,title')->order('ordernum desc')->select();
	$str .= '<select name="category_id" id="category_id">';
	foreach($categoryList as $key=>$value) {
		$str .= '<option value="'.$value['my_id'].'">'.$value['title'].'</option>';
	}
	echo $str .= '</select>';
}

/**
 * 友情链接下拉
 */
function selectLinkOptions() {
	$linkDao = M('Link');
	$lang = L('language'); //获取当前语言
	$linkList = $linkDao->where(array('is_publish'=>1))->order('is_top desc, ordernum desc, create_time desc')->select();
	foreach($linkList as $key=>$value) {
		$str .= '<option value="'.$value['url'].'">'.$value['title'].'</option>';
	}
	echo $str;
}

/**
 * 切换语言--只有两种语言时可用
 */
function switchLang() {
	$lang = L('language');
	if( $lang=='zh-CN' || $lang=='zh-cn' ) {
		echo '<a href="__APP__?l=en-US">ENGLISH</a>';
	} else {
		echo '<a href="__APP__?l=zh-CN">简体中文</a>';
	}
}

/**
 * 查找产品多图片
 */
function selectGoodsPhoto() {
	$gpDao = M('GoodsPhoto');
	$gpList = $gpDao->where(array('goods_id'=>$_GET['id'],'is_publish'=>1))->order('ordernum desc')->select();
	return $gpList;
}

/**
 * 自动获取分类模板URL
 */
function getCategoryUrl( $vo ) {
    if( empty($vo['alias']) ) {
        $url = __APP__.'/'.MODULE_NAME.'/index/cid/'.$vo['my_id'].'.html';
    } else {
        $url = __APP__.'/'.$vo['alias'].'.html';
    }
    return $url;
}

/**
 * 查找子分类
 */
function selectSubCategory( $pid ) {
    $categoryDao = M('Category');
    $lang = L('language');
    $categoryList = $categoryDao->where(array('pid'=>$pid,'is_publish'=>1,'lang'=>$lang))->order('ordernum desc')->select();
    return $categoryList;
}

/**
 * 单个广告输出
 * @param int $cid
 */
function getAdvertOne( $cid ) {
    $advertDao = M('Advert');
    $lang = L('language');
    $obj = $advertDao->where(array('category_id'=>$cid,'is_publish'=>1,'lang'=>$lang))->find();
    echo '<img src="'.__PUBLIC__.'/data/upload/images/adver/m_'.$obj['image'].'" width="'.$obj['width'].'" height="'.$obj['height'].'" />';
}
