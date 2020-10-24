<?php
//引入模块公共方法文件
require("foundation/module_users.php");
require("foundation/aintegral.php");
require("foundation/fcontent_format.php");
require("api/base_support.php");

//语言包引入
$pu_langpackage = new pubtooslp;
$u_langpackage = new userslp;


//保存图片以及图片信息
dbtarget('w', $dbServs);
$dbo = new dbex();

$user_id = get_sess_userid();//用户ID
$user_ico = $_POST['user_ico'];

//定义文件表
$t_users = $tablePreStr . 'users';
$sql = "update {$t_users} set user_ico='{$user_ico}' where user_id='{$user_id}' ";
$dbo->exeUpdate($sql);
$chat_ico = "http://".$_SERVER["HTTP_HOST"]."/".$user_ico;
$dbo->exeUpdate("update chat_users set u_ico='{$chat_ico}' where uid='{$user_id}'");
echo "1";
?>

