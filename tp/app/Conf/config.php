<?php
if (!defined('THINK_PATH'))	exit();
$config = require("config.inc.php");
$array =array(
	//'配置项'=>'配置值'
	'LAYOUT_ON'=>true
);
return array_merge($config,$array);
?>