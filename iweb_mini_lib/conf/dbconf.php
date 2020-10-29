<?php
	$host="127.0.0.1";//mysql数据库服务器,比如localhost:3306
	$db="www_puivip_com"; //默认数据库名
	$user="www_puivip_com"; //mysql数据库默认用户名
	$pwd="XszMBr3s8G3jTc3j"; //mysql数据库默认密码

	global $tablePreStr;//设置外部变量
	$tablePreStr="wy_";//表前缀

	$ws_url = "ws://jyo.com:7272";
	//当前提供服务的mysql数据库
	global $dbServs;
	$dbServs=array($host,$db,$user,$pwd);
?>
