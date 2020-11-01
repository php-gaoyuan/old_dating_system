<?php
require("session_check.php");
$dbo = new dbex;
dbtarget('w',$dbServs);
$sql = "update wy_users set is_service=$_GET[type] where user_id=$_GET[user_id]"; 
if($dbo->exeUpdate($sql)){
	echo "操作成功";
}else{
	echo "操作失败";
}
if($_GET[type]!=0){
	$sql="select user_id,user_name from wy_users where user_id=$_GET[user_id]";
	$user_info=$dbo->getRow($sql);
	$serv_list=$dbo->getRow("select user_id from wy_servicers where user_id=$_GET[user_id]");
	if(!$serv_list['user_id']){
		$sql="insert into wy_servicers(`user_id`,`user_name`) values('$user_info[user_id]','$user_info[user_name]')";
		$dbo->exeUpdate($sql);
	}
}else{
	$dbo->exeUpdate("delete from `wy_servicers` where user_id='$_GET[user_id]'");
}
?>