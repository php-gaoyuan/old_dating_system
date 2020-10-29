<?php
require("session_check.php");
require("../api/base_support.php");
	
	//变量区
	if(empty($group_id)){
		$group_id=intval(get_argg('group_id'));
		$type_value=intval(get_argg('type_value'));
	}
	$dbo = new dbex;
	dbtarget('w',$dbServs);
	
	//表定义区
	$t_group=$tablePreStr."groups";
	$time=time();
	if($type_value==0){
		$sql="update $t_group set recommed_time=null where group_id=$group_id";
		if($dbo->exeUpdate($sql)){
			echo 1;exit;
		}
	}else{
		$sql="update $t_group set recommed_time='$time' where group_id=$group_id";
		if($dbo->exeUpdate($sql)){
			echo 0;exit;
		}
	}
	
	
?>