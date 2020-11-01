<?php
header("content-type:text/html;charset=utf-8");
require("foundation/asession.php");
require("iweb_mini_lib/transapi.php");//百度翻译接口
require("configuration.php");
require("includes.php");
//初始化数据库连接
$dbo = new dbex;
dbtarget('r', $dbServs);//定义读操作




$user_id = get_sess_userid() ? get_sess_userid() : '';
$fid = $_REQUEST['fid'];//对方ID
$need = 1;
$_REQUEST['ne'];//需要的金币数量
$tos = $_REQUEST['tos'];//翻译为何种语言
$txt = strip_tags(trim($_REQUEST['lan']));//接收需要翻译的文本




$fanyi_res = translate($txt, 'auto', $tos);
$fanyi_res = $fanyi_res["trans_result"][0]["dst"];
if ($fanyi_res) {//返回翻译后文本
    exit($fanyi_res);
} else {
    exit($txt);
}





//以下代码弃用
$arr = $dbo->getRow("select user_sex,golds,user_name from wy_users where user_id='$user_id' ");
if ($arr["user_sex"] == 0) {
    $fanyi_res = $translate->translate($txt, 'auto', $tos);
    $fanyi_res = $fanyi_res["trans_result"][0]["dst"];
    if ($fanyi_res) {//返回翻译后文本
        echo $fanyi_res;
    } else {
        echo $txt;
    }
    exit;
}


if ($arr['golds'] >= $need) {
    $golds_res = $arr['golds'] - $need;//扣费后金币数量
    dbtarget('w', $dbServs);//定义写操作
    $res = $dbo->exeUpdate("update wy_users set golds='$golds_res' where user_id='$user_id'");
    //写入消费记录
    $from_userinfo = $dbo->getRow("select user_id,user_name from wy_users where user_id='$fid'");
    $ordernumber = "FY" . time() . mt_rand(100, 999);
    $dbo->exeUpdate("insert into wy_balance set type='5',uid='$user_id',uname='$arr[user_name]',touid='$from_userinfo[user_id]',touname='$from_userinfo[user_name]',message='$arr[user_name] => $from_userinfo[user_name]翻译花费" . $need . "',state='2',addtime='" . date('Y-m-d H:i:s') . "',funds='$need',ordernumber='$ordernumber'");


    $fanyi_res = $translate->translate($txt, 'auto', $tos);
    $fanyi_res = $fanyi_res["trans_result"][0]["dst"];
    if ($fanyi_res) {//返回翻译后文本
        echo $fanyi_res;
    } else {
        echo $txt;
    }
    exit;
} else {
    echo 0;//返回翻译后文本// 0 为金币不足
    exit;
}

?>