<?php
require("../includet.php");

//初始化数据库
$dbo = new dbex;
dbtarget('w', $dbServs);
$act = isset($_REQUEST["act"]) && !empty($_REQUEST["act"]) ? $_REQUEST["act"] : 'index';
$wz_userid = get_session('wz_userid');

if ($act == "index") {
    $page = $_GET["page"] ? $_GET["page"] : 1;
    $limit = $_GET["limit"] ? $_GET["limit"] : 10;
    $limit_sql = ($page - 1) * $limit . "," . $limit;
    $where = " tuid='{$wz_userid}' ";


    $user_name = isset($_GET["user_name"]) ? $_GET["user_name"] : '';
    if (!empty($user_name)) {
        $where .= " and user_name like '%{$user_name}%' ";
    }

    $user_group = isset($_GET["user_group"]) ? $_GET["user_group"] : 'all';
    if (in_array($user_group,['1','2','3'])) {
        $where .= " and user_group='{$user_group}' ";
    }

    $is_online = isset($_GET["is_online"]) ? $_GET["is_online"] : 'all';
    if (in_array($is_online,['1','0'])) {
        $where .= " and is_online='{$is_online}' ";
    }

    if ($where != " tuid='{$wz_userid}' ") {
        $page = 1;
        $limit_sql = ($page - 1) * $limit . "," . $limit;
    }

    $count_sql = "select count(*) as count from wy_users where {$where}";
    $list_sql = "select * from wy_users where {$where} order by user_id desc limit {$limit_sql}";
    //exit($list_sql);
    $count = $dbo->getRow($count_sql, 'arr');
    $list = $dbo->getALL($list_sql, 'arr');
    foreach ($list as $k => $val) {
        $upgrade_log = $dbo->getRow("select endtime from wy_upgrade_log where mid='{$val['user_id']}'");
        $list[$k]['end_date'] = $upgrade_log['endtime'];
        $list[$k]['online_update_time'] = date("Y-m-d H:i:s",$val['online_update_time']);
    }
    echo json(array("code" => 0, "count" => $count["count"], "data" => $list, "msg" => ""));
    exit;
}