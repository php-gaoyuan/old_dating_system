<?php
$pu_langpackage=new publiclp;
$dbo = new dbex;
dbtarget('r',$dbServs);
$from_id=$_GET['from_id'];
$to_id=$_GET['to_id'];
$uinfo=$dbo->getRow("select golds,user_name from wy_users where user_id='$from_id'");
if($uinfo['golds']<3){
	echo $pu_langpackage->less_golds;exit;
}
$toinfo=$dbo->getRow("select user_name from wy_users where user_id='$to_id'");
$from_name=$uinfo['user_name'];
$to_name=$toinfo['user_name'];
$start_time=time();
$sql="insert into wy_service_note (from_id,from_name,to_id,to_name,start_time) values('$from_id','$from_name','$to_id','$to_name','$start_time')";
$dbo->exeUpdate($sql);
?>