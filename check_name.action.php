<?php
	header("content-type:text/html;charset=utf-8");
	require("foundation/asession.php");
	require("configuration.php");
	require("includes.php");

	//表定义区
	$t_users=$tablePreStr."users";

	$dbo = new dbex;
	dbtarget('r',$dbServs);

	//变量区
	$user_name=short_check(get_argg('user_name'));
	$info=$dbo->getRow("select user_name from wy_users where user_name='$user_name'");
	
	if($info){
		echo '1';
	}else{
		echo '';
	}

?>