<?php
require("session_check.php");
require("../api/base_support.php");
	$is_check=check_rights("c02");
	if(!$is_check){
		echo 'no permission';
		exit;
	}
	//变量区
	if(empty($user_id)){
		$user_id=intval(get_argg('user_id'));
		$type_value=short_check(get_argg('type_value'));
	}
	$dbo = new dbex;
	dbtarget('w',$dbServs);
		
	$sql="update wy_wangzhuan set loginstate='$type_value' where id='$user_id'";
	$dbo->exeUpdate($sql);
?>