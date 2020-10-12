<?php
//引入公共模块
require("api/base_support.php");
$er_langpackage=new rechargelp;

$zibi=get_argp("zibi");

$money=0;$day=0;$groups='base';
switch ($zibi)
{
	case 'gj1':
		$money=30;
		$day=30;
		$groups='1';
	  break;
	case 'gj2':
		$money=50;
		$day=90;
		$groups='1';
	  break;
	case 'gj3':
		$money=80;
		$day=180;
		$groups='1';
	  break;
	case 'gj4':
		$money=150;
		$day=360;
		$groups='1';
	  break;
	case 'vip1':
		$money=30;
		$day=30;
		$groups='2';
	  break;
	case 'vip2':
		$money= 50;
		$day=90;
		$groups='2';
	  break;
	case 'vip3':
		$money=90;
		$day=180;
		$groups='2';
	  break;
	case 'vip4':
		$money=150;
		$day=360;
		$groups='2';
	  break;
	case 'zvip1':
		$money=199;
		$day=30;
		$groups='3';
	  break;
	case 'zvip2':
		$money=499;
		$day=90;
		$groups='3';
	  break;
	case 'zvip3':
		$money=899;
		$day=180;
		$groups='3';
	  break;
	case 'zvip4':
		$money=1499;
		$day=360;
		$groups='3';
	  break;
	default:
		$money=0;
		$day=0;
		$groups='base';
}

$dbo = new dbex;
//读写分离定义函数
dbtarget('w',$dbServs);
$user_id = get_sess_userid();
$user_name = get_sess_username();
$sql="select * from wy_users where user_id='{$user_id}'";
$golds=$dbo->getRow($sql);
if($golds['golds']-$money<0)
{
	echo "<script>alert('".$er_langpackage->er_mess2."');location.href='/modules.php?app=user_pay';</script>";
	exit();
}
//扣除金币
$sql = "UPDATE wy_users SET golds=golds-{$money} WHERE user_id='{$user_id}'";
if($dbo->exeUpdate($sql))
{

	$mid="";

	$ordernumber='S-P'.time().mt_rand(100,999);
	$touser=get_argp("touser");
	if($touser=='1')
	{
		$mid=$user_id;
		$sql="insert into wy_balance set type='2',uid='$user_id',uname='$user_name',touid='$user_id',touname='$user_name',message='会员自己升级消费".$money."',state='2',addtime='".date('Y-m-d H:i:s')."',funds='$money',ordernumber='$ordernumber'";
	}
	else if($touser=='2')
	{
		if(get_argp("friends"))
		{
			$sql="select * from wy_users where user_name = '".get_argp("friends")."'";
			$touser=$dbo->getRow($sql);
			$mid=$touser['user_id'];
			$sql="insert into wy_balance set type='2',uid='$user_id',uname='$user_name',touid='".$touser['user_id']."',touname='".$touser['user_name']."',message='{$user_name}给{$touser['user_name']}升级，消费".$money."',state='2',addtime='".date('Y-m-d H:i:s')."',funds='$money',ordernumber='$ordernumber'";
		}
		else
		{
			echo "<script>alert('".$er_langpackage->er_userrecharge."');location.href='/modules.php?app=user_pay';</script>";
			exit();
		}
	}

	$dbo->exeUpdate($sql);

	$upgrade=$dbo->getRow("select * from wy_upgrade_log where mid='$mid' and state='0' order by id desc limit 1");

	if($upgrade){	
		if($groups==$upgrade['groups']){
			$nowtime=$upgrade['endtime'];
		}else{
			$nowtime=date("Y-m-d");
		}

	}
	else
	{
		$nowtime=date("Y-m-d");
	}

	$sql="update wy_upgrade_log set state='1' where mid='$mid'";
	$dbo->exeUpdate($sql);

	//$nowtime=date("Y-m-d");
	
	$end=date("Y-m-d",strtotime($nowtime)+$day*24*3600);

	$sql="insert into wy_upgrade_log set mid='$mid',groups='$groups',howtime='$day',state='0',addtime='".date('Y-m-d H:i:s')."',endtime='$end'";
	$dbo->exeUpdate($sql);
}
echo "<script>location.href='/modules.php?app=user_consumption';</script>";
exit();
?>