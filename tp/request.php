<?php
header('Content-type:text/html;charset=utf-8');
$mysql = mysql_connect('localhost','root','');
mysql_query('set names utf8',$mysql);
mysql_select_db('thinkphp',$mysql);
$page = isset($_GET['page'])?(int)$_GET['page']:0;
$num = isset($_GET['requestNum'])?(int)$_GET['requestNum']:2;
$startNum = $page*$num;
$rows = mysql_query('select * from thinkphp_article limit '.$startNum.','.$num.'');
$data = array();
 while($row = mysql_fetch_assoc($rows)){
    $data[] = $row;
 }
echo json_encode($data);
 ?>