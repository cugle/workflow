<?php
if (!defined('THINK_PATH'))	exit();
$config = require("config.inc.php");
$array =array(
	//'配置项'=>'配置值'
    'URL_MODEL' => 0,
	//DEFAULT_LANG' => 'zh-cn',
    'LANG_SWITCH_ON' => true,
    'DEFAULT_LANG' => 'zh-cn', // 默认语言
    'LANG_AUTO_DETECT' => true, // 自动侦测语言
 	//'APP_AUTOLOAD_PATH'=>'@.TagLib',//
	'IGNORE_PRIV_LIST'=>array(
		array(
			'module_name'=>'Admin',
			'action_list'=>array('ajaxCheckUsername')
		),
		array(
			'module_name'=>'Public',
			'action_list'=>array()
		),
		array(
			'module_name'=>'Index',
			'action_list'=>array('verify','index')
		)
	),	
	
	  //'URL_CASE_INSENSITIVE' =>true,    
    'APP_AUTOLOAD_PATH' => '@.TagLib', //自动加载项目类库
	'TMPL_ACTION_ERROR'     => 'Public:error',
    'TMPL_ACTION_SUCCESS'   => 'Public:success',
);
return array_merge($config,$array);
?>