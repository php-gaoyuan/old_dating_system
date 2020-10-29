<?php
	//引入公共模块
	require("foundation/module_event.php");
	require("api/base_support.php");
	
	//引入语言包
	$er_langpackage=new rechargelp;
	
	//必须登录才能浏览该页面
	require("foundation/auser_mustlogin.php");

	$user_id=get_sess_userid();
	//限制时间段访问站点
	limit_time($limit_action_time);
?>