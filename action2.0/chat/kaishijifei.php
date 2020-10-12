<?php
$pu_langpackage=new publiclp;
$dbo = new dbex;
dbtarget('r',$dbServs);
$user_id=get_sess_userid();
$to_id=$_GET['to_id'];
$golds_one=$_GET['golds_one'];
$uinfo=$dbo->getRow("select golds,zx_try,user_name from wy_users where user_id='$user_id'");
if($uinfo['golds']<3){
	exit(1);//金币不足
}
$golds=$uinfo['golds']-$golds_one;
if($uinfo['zx_try']!=1){
	$zx_try=",`zx_try`=1";
}else{
	$zx_try=' ';
}

$touser=$dbo->getRow("select user_name from wy_users where user_id='$to_id'");
$time=date("Y-m-d");
$$ordernum="ZX".time().mt_rand(100,999);
$sql="insert into wy_palance (`type`,`uid`,`uname`,`touid`,`touname`,`message`,`state`,`addtime`,`funds`,`ordernumber`,`money`) values ('7','$user_id','$uinfo[user_name]','$to_id','$touser[user_name]','$uinfo[user_name]咨询$touser[user_name]花费$golds_one','2','$time','$golds_one','$ordernum','$golds_one')";
$dbo->exeUpdate($sql);
$sql="update wy_users set `golds`='$golds'".$zx_try." where user_id='$user_id'";

$dbo->exeUpdate($sql);


?>