<?php
require("../session_check.php");
$act = isset($_REQUEST["act"]) && !empty($_REQUEST["act"]) ? $_REQUEST["act"]:'list_log';

//初始化数据库
$t_users = $tablePreStr . "users";
$dbo = new dbex;
dbtarget('w', $dbServs);

if($act == "list_log"){
	$user_id = $_REQUEST["user_id"];
	$page = $_GET["page"]?$_GET["page"]:1;
    $limit = $_GET["limit"]?$_GET["limit"]:10;
    $limit_sql = ($page-1)*$limit.",".$limit;



	$where = " fromid='{$user_id}' or toid='{$user_id}' ";
	$count_sql="select count(*) as count from chat_log where {$where}";
    $list_sql="select * from chat_log where {$where} order by id desc limit {$limit_sql}";
    $count = $dbo->getRow($count_sql,'arr');
    $list = $dbo->getALL($list_sql,'arr');
    foreach ($list as $k => $val) {
    	$touser = $dbo->getRow("select user_name from wy_users where user_id='{$val['toid']}'","arr");
    	$list[$k]['toname'] = $touser["user_name"];
    	$list[$k]['timeline'] = date("Y/m/d H:i:s",$val["timeline"]);
    }
	//halt($list_sql);
	echo json(array("code" => 0, "count" => $count["count"], "data" => $list, "msg" => ""));exit;
}