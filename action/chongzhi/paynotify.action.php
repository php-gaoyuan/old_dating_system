<?php
//引入公共模块
require("api/base_support.php");
$er_langpackage=new rechargelp;

$dbo = new dbex;
//读写分离定义函数
dbtarget('w',$dbServs);

$code=get_argg('code');

require("payment/".$code.".php");
$pay=new $code;
$pay->dsql=$dbo;
$msg=$pay->respond();
if($msg)
{
	echo "<script>alert('".$er_langpackage->er_rechargegood."');frame_content.location.href='/modules.php?app=user_paylog';</script>";
	exit();
}
else
{
	echo "<script>alert('".$er_langpackage->er_rechargewill."');frame_content.location.href='/modules.php?app=user_paylog';</script>";
	exit();
}
?>