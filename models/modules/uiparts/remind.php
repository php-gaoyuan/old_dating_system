<?php
//引入语言包
$rem_langpackage=new remindlp;

//引入提醒模块公共函数
require("foundation/fdelay.php");
require("api/base_support.php");

//表定义区
$t_online=$tablePreStr."online";
$isset_data="";
$DELAY_ONLINE=4;
$is_action=delay($DELAY_ONLINE);

if($is_action){
	$dbo=new dbex;
	dbtarget('w',$dbServs);
	update_online_time($dbo,$t_online);
	rewrite_delay();
}
$remind_rs=api_proxy("message_get","remind");

if($langPackagePara=='zh')
{
	$remind_rs2=array();
	foreach($remind_rs as $r)
	{
		$mess=$r[4];
		$mess=str_replace("hello","个招呼",$mess);
		$mess=str_replace("A notice","个通知",$mess);
		$mess=str_replace("Message","封邮件",$mess);
		$mess=str_replace("Message","张小纸条",$mess);
		$mess=str_replace("Comments","条留言",$mess);
		$mess=str_replace("Comments","条评论",$mess);

		$mess=str_replace("Replied to your mood","回复了您的心情",$mess);
		$mess=str_replace("Replied to your blog","回复了您的日志",$mess);
		$mess=str_replace("Replied to your photo","回复了您的照片",$mess);
		$mess=str_replace("You replied album","回复了相册",$mess);

		$r[4]=$mess;
		$r['content']=$mess;
		$remind_rs2[]=$r;
	}
	$remind_rs=$remind_rs2;
}
else if($langPackagePara=='en')
{
	$remind_rs2=array();
	foreach($remind_rs as $r)
	{
		$mess=$r[4];
		$mess=str_replace("个招呼"," hello",$mess);
		$mess=str_replace("个通知"," A notice",$mess);
		$mess=str_replace("封邮件"," Message",$mess);
		$mess=str_replace("张小纸条"," Message",$mess);
		$mess=str_replace("条留言"," Comments",$mess);
		$mess=str_replace("条评论","Comments",$mess);

		$mess=str_replace("中回复了您","",$mess);
		$mess=str_replace("问题","",$mess);
		$mess=str_replace("在心情","Replied to your mood",$mess);
		$mess=str_replace("在日志","Replied to your blog",$mess);
		$mess=str_replace("在照片","Replied to your photo",$mess);
		$mess=str_replace("在相册","Replied to your album",$mess);

		$r[4]=$mess;
		$r['content']=$mess;
		$remind_rs2[]=$r;
	}
	$remind_rs=$remind_rs2;
}

if(empty($remind_rs)){
	$isset_data="content_none";
}
?>