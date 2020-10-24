<?php
require("../session_check.php");
$act = isset($_REQUEST["act"]) && !empty($_REQUEST["act"]) ? $_REQUEST["act"]:'index';

//初始化数据库
$t_users = $tablePreStr . "users";
$dbo = new dbex;
dbtarget('w', $dbServs);

if($act == "index"){
    $page = $_GET["page"]?$_GET["page"]:1;
    $limit = $_GET["limit"]?$_GET["limit"]:10;
    $limit_sql = ($page-1)*$limit.",".$limit;

    $user_name = $_GET["user_name"];
    $where = " true ";
    if(!empty($user_name)){
        $where .= " and user_name like '%{$user_name}%' ";
    }

    $count_sql="select count(*) as count from {$t_users} where {$where}";
    $list_sql="select * from {$t_users} where {$where} order by user_id desc limit {$limit_sql}";
    $count = $dbo->getRow($count_sql,'arr');
    $list = $dbo->getALL($list_sql,'arr');
    echo json(array("code" => 0, "count" => $count["count"], "data" => $list, "msg" => ""));exit;
}elseif($act=="edit"){

}else{
    return json("0","ok",[]);
}


