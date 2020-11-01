<?php
	//require("session_check.php");
	

	//表定义区
	$t_users=$tablePreStr."users";

	$dbo = new dbex;
	dbtarget('w',$dbServs);

	//变量区
	$user_id=get_sess_userid();
	$guest_user_id=short_check(get_argg('user_id'));
	

	
	//删除访客
	if($guest_user_id){
		$sql="delete from wy_guest where user_id='$user_id' and guest_user_id='$guest_user_id'";
	}else{
		$sql="delete from wy_guest where user_id='$user_id'";
	}
	$res=$dbo->exeUpdate($sql);
	if($res){
		header("location:modules2.0.php?app=guest_more&user_id=$user_id");
	}
?>