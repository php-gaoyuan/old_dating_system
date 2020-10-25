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
    foreach ($list as $k => $val) {
        $tuinfo = $dbo->getRow("select name from wy_wangzhuan where id='{$val['tuid']}'");
        $list[$k]['tuname'] = $tuinfo['name'];
        $upgrade_log = $dbo->getRow("select endtime from wy_upgrade_log where mid='{$val['user_id']}'");
        $list[$k]['end_date'] = $upgrade_log['endtime'];
    }
    echo json(array("code" => 0, "count" => $count["count"], "data" => $list, "msg" => ""));exit;
}elseif($act=="edit"){

}elseif($act=="changeTuid"){
    $user_id = intval($_POST["user_id"]);
    $tuid = intval($_POST["tuid"]);
    $sql = "update wy_users set tuid='{$tuid}' where user_id={$user_id}";
    //exit($sql);
    $res = $dbo->exeUpdate($sql);
    echo json(array("code" => 0, "msg" => "操作成功", "data" =>[] ));exit;
}elseif($act=="changeIsPass"){
    $user_id = intval($_POST["user_id"]);
    $userinfo = $dbo->getRow("select * from wy_users where user_id={$user_id}","arr");
    //halt($userinfo);
    if($userinfo['is_pass']==0){
        $is_pass = 1;
    }else{
        $is_pass=0;
    }
    $dbo->exeUpdate("update wy_users set is_pass='{$is_pass}' where user_id='{$user_id}'");
    echo json(array("code" => 0, "msg" => "操作成功", "data" =>[] ));exit;
}elseif($act=="resetPass"){
    $user_id = intval($_POST["user_id"]);
    $user_pws = md5("qwe1234");
    $dbo->exeUpdate("update wy_users set user_pws='{$user_pws}' where user_id={$user_id}");
    echo json(array("code" => 0, "msg" => "密码已经重置为：qwe1234", "data" =>[] ));exit;
}elseif($act=="delUser"){
    $user_id = intval($_POST["user_id"]);
    $dbo->exeUpdate("delete from wy_users where user_id={$user_id}");
    $dbo->exeUpdate("delete from chat_users where uid={$user_id}");
    echo json(array("code" => 0, "msg" => "操作成功", "data" =>[] ));exit;
}elseif($act=="changeGold"){
    $user_id = intval($_POST["user_id"]);
    $gold = ($_POST["gold"]);
    $dbo->exeUpdate("update wy_users set golds='{$gold}' where user_id={$user_id}");
    echo json(array("code" => 0, "msg" => "金条添加成功", "data" =>[] ));exit;
}else{
    return json("0","ok",[]);
}


