<?php
require("../includet.php");

//初始化数据库
$dbo = new dbex;
dbtarget('w', $dbServs);
$act = isset($_REQUEST["act"]) && !empty($_REQUEST["act"]) ? $_REQUEST["act"] : 'index';


if ($act == "index") {
    if(!isset($_GET["user_name"]) || empty($_GET["user_name"])){
        echo json(array("code" => 0, "count" => 0, "data" => [], "msg" => ""));exit;
    }
    $page = $_GET["page"] ? $_GET["page"] : 1;
    $limit = $_GET["limit"] ? $_GET["limit"] : 10;
    $limit_sql = ($page - 1) * $limit . "," . $limit;

    $user_name = $_GET["user_name"];
    $sql = "select user_id,user_name,tuid from wy_users where user_name like '{$user_name}%' or user_name = '{$user_name}'";
    $userList = $dbo->getAll($sql,"arr");
    echo json(array("code" => 0, "count" => 10, "data" => $userList, "msg" => ""));exit;
}elseif ($act == "act_bang") {
    $wz_user_id = get_session('wz_userid');
    $user_id = intval($_POST["user_id"]);
    $userInfo = $dbo->getRow("select tuid from wy_users where user_id='{$user_id}'", "arr");
    if ($userInfo["tuid"] > 0) {
        echo json(array("code" => 0, "msg" => "该用户已经绑定过上级", "url"=>"" ));exit;
    }
    $sql = "update wy_users set tuid = '{$wz_user_id}' where user_id='{$user_id}'";
    $res = $dbo->exeUpdate($sql);
    if ($res) {
        echo json(array("code" => 0, "msg" => "绑定成功", "url"=>"" ));exit;
    } else {
        echo json(array("code" => 0, "msg" => "绑定失败", "url"=>"" ));exit;
    }
}
?>