<?php
return array(

	/* 项目设定 */
	'APP_DEBUG'             => 1,
	'SHOW_PAGE_TRACE'       => 0,
	'TMPL_CACHE_ON'			=> false,
	'APP_GROUP_LIST'        => 'Mobile,Home,Admin',
    'DEFAULT_GROUP'         => 'Mobile',  // 默认分组
	'DEFAULT_ACTION'        => 'index', // 默认操作名称
	'TMPL_PARSE_STRING'     => array('__ADMIN__'=>__ROOT__.'/'.APP_NAME.'/Tpl/default/Admin',
									 '__HOME__'=>__ROOT__.'/'.APP_NAME.'/Tpl/default/Home/Public',
									 '__MOBILE__' => __ROOT__.'/'.APP_NAME.'/Tpl/default/Mobile/Public',
									 '__UPLOAD__' =>__ROOT__.'/Public/data/upload',
								),

	/* 数据库设置 */
	'DB_TYPE'               => 'mysql',
	'DB_HOST'               => 'localhost',
	'DB_NAME'               => 'db_haotj',
	'DB_USER'               => 'root',
	'DB_PWD'                => 'root',
	'DB_PORT'               => '3306',
	'DB_PREFIX'             => 'm_',

	/* URL设置 */
	'URL_ROUTER_ON'         => true,
	'URL_MODEL'             => 1,
	'URL_HTML_SUFFIX'       => '.html',

	/* 语言设置 */
	'LANG_SWITCH_ON'        => true, 
  	'DEFAULT_LANG'          => 'zh-cn',
  	'LANG_AUTO_DETECT'      => true,
	'UPLOAD_FILE_RULE'      => 'Public/data/upload/',


	/* RBAC */
    'RBAC_NODE_TABLE'           =>'qweb_node',
	'USER_AUTH_ON'              =>true,
    'USER_AUTH_TYPE'	        =>2,		// 默认认证类型 1 登录认证 2 实时认证
    'USER_AUTH_KEY'             =>'admin',	// 用户认证SESSION标记
    'ADMIN_AUTH_KEY'	        =>'administrator',
    'USER_AUTH_MODEL'           =>'User',	// 默认验证数据表模型
    'AUTH_PWD_ENCODER'          =>'md5',	// 用户认证密码加密方式
    'USER_AUTH_GATEWAY'         =>'/Public/login',// 默认认证网关
    'NOT_AUTH_MODULE'           =>'Public',	// 默认无需认证模块
    'REQUIRE_AUTH_MODULE'       =>'',		// 默认需要认证模块
    'NOT_AUTH_ACTION'           =>'',		// 默认无需认证操作
    'REQUIRE_AUTH_ACTION'       =>'',		// 默认需要认证操作
    'GUEST_AUTH_ON'             =>false,    // 是否开启游客授权访问
    'GUEST_AUTH_ID'             =>0,        // 游客的用户ID
);
?>