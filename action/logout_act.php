<?php
//会员退出
$dbo = new dbex;
dbtarget('r',$dbServs);
$t_online=$tablePreStr."online";
$user_id=get_sess_userid();
if(empty($user_id))
{
	setcookie("IsReged",'');
	session_regenerate_id();
	session_destroy();
	echo '<script language=javascript>top.location="/";</script>';
}
else
{
	$user_id=get_sess_userid();
	$now_time=time();

	$sql="select active_time from $t_online where user_id=$user_id";
	$online=$dbo->getRow($sql);

	$sql="select nowdatetime,lastlogin_datetime from wy_users where user_id='".$user_id."'";
	$user = $dbo->getRow($sql);

	if(date('Y-m-d',strtotime($user['lastlogin_datetime']))==date('Y-m-d',$now_time))
	{
		if($online['active_time']-strtotime($user['lastlogin_datetime'])>=28800)
		{
			if(empty($user['nowdatetime']))$nowdatetime=1;else $nowdatetime=$user['nowdatetime']+1;
			$sql="update wy_users set nowdatetime='".$nowdatetime."' where user_id='".$user_id."'";
			$dbo->exeUpdate($sql);
		}
		else if($online['active_time']-strtotime($user['lastlogin_datetime'])>=21800)
		{
			
			if(empty($user['nowdatetime']))$nowdatetime=0.5;else $nowdatetime=$user['nowdatetime']+0.5;
			$sql="update wy_users set nowdatetime='".$nowdatetime."' where user_id='".$user_id."'";
			$dbo->exeUpdate($sql);
		}
	}
	$lastlogin_datetime = date('Y-m-d H:i:s',$now_time);
	$sql="delete from $t_online where user_id=$user_id";
	$dbo->exeUpdate($sql);
	$sql="update wy_users set lastlogin_datetime='".$lastlogin_datetime."' where user_id='".$user_id."'";
	$dbo->exeUpdate($sql);
	setcookie("IsReged",'');
	session_regenerate_id();
	session_destroy();
	action_return(1,'','');
}

?>