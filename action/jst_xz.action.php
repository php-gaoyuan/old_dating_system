<?php
	//引入模块公共方法文件
	$RefreshType='ajax';
	require("foundation/aanti_refresh.php");
	require("api/base_support.php");

	//引入语言包
	$mo_langpackage=new moodlp;

	//变量取得
	$user_id=get_sess_userid();
	$dbo = new dbex;
	//读写分离定义函数
	dbtarget('w',$dbServs);
	
	$uinfo=$dbo->getRow("select user_group,jst_num from wy_users where user_id='$user_id'");
	if($uinfo['jst_num']>40){
		echo 1;//试用条数超过40提示
		exit;
	}else{
		echo 2;
	}
	$ugroup=(int)$uinfo['user_group'];
	if($ugroup<2){
		$jst_num=$uinfo['jst_num']+1;
		$dbo->exeUpdate("update wy_users set jst_num='$jst_num' where user_id='$user_id'");
	}
	
?>