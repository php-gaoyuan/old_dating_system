<?php
	require("api/base_support.php");
	$msg_inbox_rs=api_proxy("scrip_inbox_get_mine","count(*)","",0);
	if(is_array($msg_inbox_rs[0]))
	{
		$msg_inbox_rs=$msg_inbox_rs[0][0];
	}
	else
	{
		$msg_inbox_rs=0;
	}

	if($msg_inbox_rs>=100)$msg_inbox_rs=99;

	$msg_notice_rs=api_proxy("scrip_notice_get","count(*)","","and readed='0'");
	if(is_array($msg_notice_rs[0]))
	{
		$msg_notice_rs=$msg_notice_rs[0][0];
	}
	else
	{
		$msg_notice_rs=0;
	}
	if($msg_notice_rs>=100)$msg_notice_rs=99;

	
	//创建系统对数据库进行操作的对象
	$dbo=new dbex();
	//对数据进行读写分离，读操作
	dbplugin('r');
	//查询用户的礼品
	$sql="select count(*) from gift_order where is_see='0' and accept_id=".get_sess_userid();
	$gifts=$dbo->getRow($sql);
	if(is_array($gifts))
	{
		$gifts=$gifts[0];
	}
	else
	{
		$gifts=0;
	}
	if($gifts>=100)$gifts=99;

	$user_id=get_sess_userid();

	$userinfo=Api_Proxy("user_self_by_uid","*",$user_id);

	echo $msg_inbox_rs."-".$msg_notice_rs."-".$gifts."-".$userinfo['golds'];
?>