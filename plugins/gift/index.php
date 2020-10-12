<?php
//打开session支持开关
$session_power=true;
//打开系统数据库支持开关
$iweb_power=true;
//引入系统文件的支持文件
include_once(dirname(__file__)."/../includes.php");
//引入自己的配制信息文件
include_once(dirname(__file__)."/config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<?php
//如果用户在线
if(get_sess_userid())
{
	//得到表名
	$order=$table_prefix."order";
	//创建系统对数据库进行操作的对象
	$dbo=new dbex();
	//数据库读写分离，读操作
	dbplugin('r');
	//取得自己的未查收的礼品
	$sql="select * from ".$order." where is_see=0 and accept_id=".get_sess_userid();
	$rows=$dbo->getRs($sql);
	//如果用户有新收到的礼品则提醒
	if(count($rows)>=1)
	{
		echo"<a href='".self_url(__file__)."gift_box.php' class='new_gift' target='frame_content'></a>";
	}
	//得到用户表
	$user=$table_prefix."user";
	//获取用户注册信息
	$sql="select * from ".$user." where user_id=".get_sess_userid();
	$rows=$dbo->getRs($sql);
	//如果用户还没有注册过
	if(count($rows)<1)
	{
		//提醒其开启礼品盒
		echo"<a href='".self_url(__file__)."gift_reg.php' target='frame_content'><img img src='".self_url(__file__)."gift.gif' width='190' height='200' style='margin-top:-24px;' title='开启礼品盒!'/></a>";
	}
	else
	{
		//如果已经登记过的用户，显示赠送的查看礼品
		echo"<a href='".self_url(__file__)."gift.php' target='frame_content'><img src='".self_url(__file__)."send.gif' title='赠送礼品'/></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo"<a href='".self_url(__file__)."gift_box.php' target='frame_content'><img src='".self_url(__file__)."accept.gif' title='查看礼品'/></a>";
	}
}
else
{
	//显示使用礼品盒的宣传
	echo"<img src='".self_url(__file__)."gift.gif' width='190' height='200' title='登录后再开启!' onclick='gift_msg()' />";
}
?>
<script>
function gift_msg()
{
	alert("登录后，才能天启礼品盒！");
}
</script>
</body>
</html>
