<?php
//开启系统对get和post的封装支持
$getpost_power=true;
//开启系统对数据库的支持
$iweb_power=true;
//引入系统文件的支持文件
include_once(dirname(__file__)."/../includes.php");
//引入自己的配制文件
include_once(dirname(__file__)."/config.php");
//获得表名
	$user=$table_prefix."user";
	//创建系统对数据库进行操作的对象
	$dbo=new dbex();
	//对数据进行读写分离，读操作
	dbplugin('r');
	//获得用户ID
	$user_id=get_sess_userid();
	//获得用户名
	$user_name=get_sess_username();
	//获得用户是否登信息
	$sql="select user_id from $user where user_id=".$user_id;
	$user_info=$dbo->getRs($sql);
	//如果没有登记
	if(count($user_info)<1)
	{
		//数据读写分离,写操作
		dbplugin('w');
		//登记用户信息
		$sql="insert into $user(user_id,user_name) values('$user_id','$user_name')";
		$dbo->exeUpdate($sql);
	}
	//转向礼品页面
	header("Location: gift.php");
?>