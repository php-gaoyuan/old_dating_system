<?php

	
	//引入公共模块
	require("foundation/module_mypals.php");
	require("foundation/module_users.php");
	require("api/base_support.php");
	//引入语言包
	$m_langpackage=new msglp;
	$b_langpackage=new bottlelp;
	//变量获得
	$user_id=get_sess_userid();
	
	$bott_reid=trim(get_argg('reid'));
	
	//数据表定义区
	$t_bottle=$tablePreStr."bottle";

	$dbo=new dbex;
	//读写分离定义方法
	dbtarget('r',$dbServs);	
	
	if(!empty($bott_reid)){
		$oneBottle=$dbo->getRow("select * from $t_bottle where bott_id=$bott_reid and (to_user_id=$user_id or from_user_id=$user_id)");
	}
?>