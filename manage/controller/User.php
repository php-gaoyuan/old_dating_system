<?php
require("../session_check.php");
$act = isset($_REQUEST["act"]) && !empty($_REQUEST["act"]) ? $_REQUEST["act"] : 'index';

//初始化数据库
$t_users = $tablePreStr . "users";
$dbo = new dbex;
dbtarget('w', $dbServs);

if ($act == "index") {
    $page = $_GET["page"] ? $_GET["page"] : 1;
    $limit = $_GET["limit"] ? $_GET["limit"] : 10;
    $limit_sql = ($page - 1) * $limit . "," . $limit;
    $where = "true";


    $user_name = isset($_GET["user_name"]) ? $_GET["user_name"] : '';
    if (!empty($user_name)) {
        $where .= " and user_name like '%{$user_name}%' ";
    }

    $user_sex = isset($_GET["user_sex"]) ? $_GET["user_sex"] : 'all';
    if (in_array($user_sex,['0','1'])) {
        $where .= " and user_sex='{$user_sex}' ";
    }

    $is_pass = isset($_GET["is_pass"]) ? $_GET["is_pass"] : 'all';
    if (in_array($is_pass,['0','1'])) {
        $where .= " and is_pass='{$is_pass}' ";
    }

    $user_group = isset($_GET["user_group"]) ? $_GET["user_group"] : 'all';
    if($user_group=="yes"){
        $where .= " and user_group>1 ";
    }elseif($user_group=="no"){
        $where .= " and user_group<2 ";
    }

    $reg_date = isset($_GET["reg_date"]) ? $_GET["reg_date"] : '';
    if (!empty($reg_date)) {
        $reg_date = explode(" - ", $reg_date);
        $reg_date[0] = date("Y-m-d H:i:s",strtotime($reg_date[0]));
        $reg_date[1] = date("Y-m-d H:i:s",strtotime($reg_date[1]."+1day"));
        $where .= " and user_add_time between '{$reg_date[0]}' and '{$reg_date[1]}' ";
    }
    if ($where != "true") {
        $page = 1;
        $limit_sql = ($page - 1) * $limit . "," . $limit;
    }

    $count_sql = "select count(*) as count from {$t_users} where {$where}";
    $list_sql = "select * from {$t_users} where {$where} order by user_id desc limit {$limit_sql}";
    //exit($list_sql);
    $count = $dbo->getRow($count_sql, 'arr');
    $list = $dbo->getALL($list_sql, 'arr');
    foreach ($list as $k => $val) {
        $tuinfo = $dbo->getRow("select name from wy_wangzhuan where id='{$val['tuid']}'");
        $list[$k]['tuname'] = $tuinfo['name'];
        $upgrade_log = $dbo->getRow("select endtime from wy_upgrade_log where mid='{$val['user_id']}'");
        $list[$k]['end_date'] = $upgrade_log['endtime'];
    }
    echo json(array("code" => 0, "count" => $count["count"], "data" => $list, "msg" => ""));
    exit;
} elseif ($act == "edit") {

} elseif ($act == "changeTuid") {
    $user_id = intval($_POST["user_id"]);
    $tuid = intval($_POST["tuid"]);
    $sql = "update wy_users set tuid='{$tuid}' where user_id={$user_id}";
    //exit($sql);
    $res = $dbo->exeUpdate($sql);
    echo json(array("code" => 0, "msg" => "操作成功", "data" => []));
    exit;
} elseif ($act == "changeIsPass") {
    $user_id = intval($_POST["user_id"]);
    $userinfo = $dbo->getRow("select * from wy_users where user_id={$user_id}", "arr");
    //halt($userinfo);
    if ($userinfo['is_pass'] == 0) {
        $is_pass = 1;
    } else {
        $is_pass = 0;
    }
    $dbo->exeUpdate("update wy_users set is_pass='{$is_pass}' where user_id='{$user_id}'");
    echo json(array("code" => 0, "msg" => "操作成功", "data" => []));
    exit;
} elseif ($act == "resetPass") {
    $user_id = intval($_POST["user_id"]);
    $user_pws = md5("qwe1234");
    $dbo->exeUpdate("update wy_users set user_pws='{$user_pws}' where user_id={$user_id}");
    echo json(array("code" => 0, "msg" => "密码已经重置为：qwe1234", "data" => []));
    exit;
} elseif ($act == "delUser") {
    $user_id = intval($_POST["user_id"]);
    $dbo->exeUpdate("delete from wy_users where user_id={$user_id}");
    $dbo->exeUpdate("delete from chat_users where uid={$user_id}");
    $dbo->exeUpdate("delete from wy_pals_mine where user_id={$user_id} or pals_id={$user_id}");
    echo json(array("code" => 0, "msg" => "操作成功", "data" => []));
    exit;
} elseif ($act == "changeGold") {
    $user_id = intval($_POST["user_id"]);
    $gold = ($_POST["gold"]);
    $dbo->exeUpdate("update wy_users set golds='{$gold}' where user_id={$user_id}");
    echo json(array("code" => 0, "msg" => "金条添加成功", "data" => []));
    exit;
} elseif ($act == "changeGroup") {
    $user_id = intval($_POST["user_id"]);
    $user_group = intval($_POST["user_group"]);
    $endtime = ($_POST["endtime"]);
    $date = date("Y-m-d H:i:s");
    $howtime = get_difference($date, $endtime);
    $dbo->exeUpdate("update wy_users set user_group='{$user_group}' where user_id={$user_id}");
    $dbo->exeUpdate("update wy_upgrade_log set state='1' where mid='{$user_id}' and state='0'");

    $dbo->exeUpdate("insert into wy_upgrade_log (mid,groups,howtime,state,addtime,endtime) values('{$user_id}','{$user_group}','{$howtime}','0','{$date}','{$endtime}')");
    echo json(array("code" => 0, "msg" => "操作成功", "data" => []));
    exit;
} else {
    return json("0", "ok", []);
}

/**
 *    日期-计算2个日期的差值
 * @return int
 */
function get_difference($date, $new_date)
{
    $date = strtotime($date);
    $new_date = strtotime($new_date);
    return abs(ceil(($date - $new_date) / 86400));
}
