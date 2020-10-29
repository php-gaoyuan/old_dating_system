<?php
	require("api/base_support.php");
	require("foundation/module_users.php");
	//引入语言包
	$mp_langpackage=new mypalslp;
	$l_langpackage=new loginlp;
	$pu_langpackage=new publiclp;
		
	
	dbtarget('r',$dbServs);
	$dbo=new dbex;
	//获取用户自定义属性列表
	$information_rs=array();
	$information_rs=userInformationGetList($dbo,'*');
?>