<?php
$host = "127.0.0.1";//mysql数据库服务器,比如localhost:3306
$db = "www_dsrramtcys_c"; //默认数据库名
$user = "www_dsrramtcys_c"; //mysql数据库默认用户名
$pwd = "NAdtkAed6wLXYdJs"; //mysql数据库默认密码

global $tablePreStr;//设置外部变量
$tablePreStr = "wy_";//表前缀

$ws_url = "wss://{$_SERVER['HTTP_HOST']}/socket.io";
//当前提供服务的mysql数据库
global $dbServs;
$dbServs = array(
    'host'=>$host,
    'db'=>$db,
    'user'=>$user,
    'pwd'=>$pwd
);
?>