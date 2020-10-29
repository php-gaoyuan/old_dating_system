<?php
function update_online_time($dbo,$table){
	$user_id=get_sess_userid();
	$now_time=time();
	$kick_time=720;//设置超时时间
	


	//gaoyuanadd 锁定的用户
	$ids = $dbo->getALL("select user_id from wy_users where is_pass='0'");
	foreach ($ids as $key => $vo) {
		$lock_ids[] = $vo["user_id"];
	}
	//print_r($lock_ids);exit;
	//$lock_ids = array("5813");
	if(in_array($user_id, $lock_ids)){
		//清除好友记录
		$dbo->exeUpdate("delete from chat_users where uid='{$user_id}'");
		//清除在线记录
		$dbo->exeUpdate("delete from wy_online where user_id='{$user_id}'");
		return true;
	}



	if($user_id){
		$sql="update $table set active_time='$now_time' where user_id=$user_id";
		if(!$dbo->exeUpdate($sql)){
			global $tablePreStr;
			$t_online=$tablePreStr."online";
			$user_id=get_sess_userid();
			$user_name=get_sess_username();
			$user_ico=get_sess_userico();
			$user_sex=get_sess_usersex();
			$sql="insert into $t_online (`user_id`,`user_name`,`user_sex`,`user_ico`,`active_time`,`hidden`) values ($user_id,'$user_name','$user_sex','$user_ico','$now_time',0)";
			$dbo->exeUpdate($sql);
		}
	}

	$sql="select active_time from $table where $now_time-active_time>$kick_time*60";
	$onlines = $dbo->getRs($sql);
	foreach($onlines as $online)
	{
		$sql="select nowdatetime,lastlogin_datetime from wy_users where user_id='".$online['user_id']."'";
		$user = $dbo->getRow($sql);
		if(date('Y-m-d',strtotime($user['lastlogin_datetime']))==date('Y-m-d',$now_time))
		{
			if($online['active_time']-strtotime($user['lastlogin_datetime'])>=28800)
			{
				if(empty($user['nowdatetime']))$nowdatetime=1;else $nowdatetime+=1;
				$sql="update wy_users set nowdatetime='$nowdatetime' where user_id='".$online['user_id']."'";
				$dbo->exeUpdate($sql);
			}
			else if($online['active_time']-strtotime($user['lastlogin_datetime'])>=21800)
			{
				if(empty($user['nowdatetime']))$nowdatetime=0.5;else $nowdatetime+=0.5;
				$sql="update wy_users set nowdatetime='$nowdatetime' where user_id='".$online['user_id']."'";
				$dbo->exeUpdate($sql);
			}
		}
	}
	$sql="delete from $table where $now_time-active_time>$kick_time*60";
	$dbo->exeUpdate($sql);
}

function rewrite_delay(){
	$now_time=time();
	$content=file_get_contents("foundation/fdelay.php");
	$content=preg_replace('/(\$LAST_DELAY_TIME)=(\d*)(;)/',"$1={$now_time}$3",$content);
	$ref=fopen("foundation/fdelay.php",'w+');
	fwrite($ref,$content);
	fclose($ref);
}

$rem_short_act=array(
	3=>"modules.php?app=mypals_request",
	10=>"modules.php?app=remind_group",
	5=>"modules.php?app=msg_minbox",
	7=>"modules.php?app=msgboard_more",
	4=>"modules.php?app=user_hi",
);
?>