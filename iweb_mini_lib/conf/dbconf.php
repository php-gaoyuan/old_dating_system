<?php
$host = "127.0.0.1";//mysql数据库服务器,比如localhost:3306
$db = "www_partyings_co"; //默认数据库名
$user = "www_partyings_co"; //mysql数据库默认用户名
$pwd = "N7FZKEnGirajFZ8r"; //mysql数据库默认密码

global $tablePreStr;//设置外部变量
$tablePreStr = "wy_";//表前缀

$ws_url = "wss://{$_SERVER['HTTP_HOST']}/socket";
//当前提供服务的mysql数据库
global $dbServs;
$dbServs = array(
    'host'=>$host,
    'db'=>$db,
    'user'=>$user,
    'pwd'=>$pwd
);
?>