<?php
require("../session_check.php");
$act = isset($_REQUEST["act"]) && !empty($_REQUEST["act"]) ? $_REQUEST["act"] : 'index';

//初始化数据库
$dbo = new dbex;
dbtarget('w', $dbServs);

if ($act == "index") {
    $page = $_GET["page"] ? $_GET["page"] : 1;
    $limit = $_GET["limit"] ? $_GET["limit"] : 10;
    $limit_sql = ($page - 1) * $limit . "," . $limit;
    $where = " type in ('1','2') ";


    $user_name = isset($_GET["user_name"]) ? $_GET["user_name"] : '';
    if (!empty($user_name)) {
        $where .= " and uname like '%{$user_name}%' ";
    }
    $ordernumber = isset($_GET["ordernumber"]) ? $_GET["ordernumber"] : '';
    if (!empty($ordernumber)) {
        $where .= " and ordernumber like '%{$ordernumber}%' ";
    }


    $pay_method = isset($_GET["pay_method"]) ? $_GET["pay_method"] : 'all';
    if (in_array($pay_method,['lianyin','yingfu'])) {
        $where .= " and pay_method='{$pay_method}' ";
    }


    $pay_date = isset($_GET["pay_date"]) ? $_GET["pay_date"] : '';
    if (!empty($pay_date)) {
        $pay_date = explode(" - ", $pay_date);
        $pay_date[0] = date("Y-m-d H:i:s",strtotime($pay_date[0]));
        $pay_date[1] = date("Y-m-d H:i:s",strtotime($pay_date[1]."+1day"));
        $where .= " and addtime between '{$pay_date[0]}' and '{$pay_date[1]}' ";
    }
//    if ($where !=  " type in ('1','2') ") {
//        $page = 1;
//        $limit_sql = ($page - 1) * $limit . "," . $limit;
//    }

    $count_sql = "select count(*) as count from wy_balance where {$where}";
    $list_sql = "select * from wy_balance where {$where} order by id desc limit {$limit_sql}";
    //exit($list_sql);
    $count = $dbo->getRow($count_sql, 'arr');
    $list = $dbo->getALL($list_sql, 'arr');

    $total_money = $dbo->getAll("select sum(money) as total_money from wy_balance where {$where} and state='2' and  pay_method in ('lianyin','yingfu')","arr");
    $total_money = !empty($total_money[0]['total_money']) ? $total_money[0]['total_money']:0;
    echo json(array("code" => 0, "count" => $count["count"], "data" => $list, "msg" => "","total_money"=>$total_money));
    exit;
} else {
    return json("0", "ok", []);
}

function getAgoTime($date){
    $time1 = strtotime($date);
    $time2=time();
    $time_cha = $time2-$time1;
    $minus = $time_cha/60;

    return ceil($minus);
}