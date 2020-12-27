<?php
require("session_check.php");
$dbo = new dbex;
dbtarget('w',$dbServs);
$info=$dbo->getRow("select mood from wy_mood where user_id='$_GET[user_id]' order by mood_id desc ");
$info1=$dbo->getRow("select user_ico from wy_users where user_id='$_GET[user_id]' ");

if($_GET['type']==1){
	if(!$info['mood'] || strlen($info1['user_ico'])<10){
		echo 0;//条件不符
		exit;
	}
}
$time=time();
$sql = "update wy_users set `is_index`='".$_GET['type']."',`index_time`='".$time."' where user_id='".$_GET[user_id]."'"; 
//echo $sql;exit;
if($dbo->exeUpdate($sql)){
	echo 1;//推荐成功
}else{
	echo 2;//推荐失败 未知错误
}
?>