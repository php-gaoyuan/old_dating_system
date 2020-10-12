<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/event/event_invite.html
 * 如果您的模型要进行修改，请修改 models/modules/event/event_invite.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
	//引入公共模块
	require("foundation/module_event.php");
	require("foundation/fpages_bar.php");
	require("api/base_support.php");
	
	//引入语言包
	$ef_langpackage=new event_frontlp;

	//变量区
	$user_id=get_sess_userid();
	$event_id=intval(get_argg('event_id'));
	$time=time();
	$no_event="";
	
	//表定义
	$t_event_members=$tablePreStr."event_members";
	$t_event_invite=$tablePreStr."event_invite";
	$t_pals_mine=$tablePreStr."pals_mine";

	//当前页面参数
	$page_num=trim(get_argg('page'));
	$my_pals_rs=array();
	$event_row=array();
	
	//权限判断
	$status=api_proxy("event_member_by_uid","status",$event_id,$user_id);
	$event_row=api_proxy("event_self_by_eid","deadline,end_time,member_num,grade,limit_num,allow_invite,is_pass",$event_id);
	if(intval($status['status']) < 3){
		//活动是否允许邀请
		if($event_row['allow_invite']==0){
			echo "<script type='text/javascript'>alert(\"$ef_langpackage->ef_no_permission\");window.history.go(-1);</script>";
			exit();
		}
	}

if($event_row['is_pass']==0 || $event_row['grade']<=0){
	$no_event=$ef_langpackage->ef_donot_failed_or_locked;
}
else if($time >= $event_row['end_time']){
	$no_event=$ef_langpackage->ef_donot_ended;
}
else if($time >= $event_row['deadline']){
	$no_event=$ef_langpackage->ef_donot_deadline;
}
else if($event_row['limit_num']>'0' && $event_row['member_num']>=$event_row['limit_num']){
	$no_event=$ef_langpackage->ef_donot_number_full;
}
else{

	//定义写操作
	dbtarget('w',$dbServs);
	$dbo=new dbex();

	//取得我的好友
	$sql="select pm.pals_id,pm.pals_name, pm.pals_sex,pm.pals_ico,(select ei.user_id from $t_event_invite as ei where ei.to_user_id = pm.pals_id and ei.event_id = $event_id) as to_user_id, (select em.user_id from $t_event_members as em where em.user_id = pm.pals_id and em.event_id = $event_id and em.status!=1) as user_id from $t_pals_mine pm where pm.user_id=$user_id and pm.accepted > 0";
	
	//$dbo->setPages(10,$page_num);//设置分页
	$my_pals_rs=$dbo->getRs($sql);
	//$page_total=$dbo->totalPage; //分页总数	
}

//显示控制
$list_none="content_none";
$isNull=0;
if(empty($my_pals_rs)){
	$isNull=1;
	$list_none="";
	$no_event=$no_event?$no_event:$ef_langpackage->ef_not_friends.', <a href="modules.php?app=mypals_search">'.$ef_langpackage->ef_add_friend_now.'</a>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
</head>
<body id="iframecontent">
<div class="create_button"><a href="javascript:window.history.go(-1)"><?php echo $ef_langpackage->ef_back;?></a></div>
<h2 class="app_event"><?php echo $ef_langpackage->ef_activity;?></h2>
<div class="tabs">
  <ul class="menu">
    <li class="active"><a href="modules.php?app=event_invite&event_id=<?php echo $event_id;?>" hidefocus="true"><?php echo $ef_langpackage->ef_invite_friends;?></a></li>
  </ul>
</div>
<?php if($isNull==0){?>
	<div class="rs_head"><?php echo $ef_langpackage->ef_join_not_invite_friends;?></div>
	<form action="do.php?act=event_invite" name="form" method="post">
		<input type="hidden" name="event_id" value="<?php echo $event_id;?>" />
	<?php foreach($my_pals_rs as $rs){?>
			<div class="group_user_list">
				<a class="avatar" href="home2.0.php?h=<?php echo $rs['pals_id'];?>" target="_blank">
					<img src="<?php echo $rs['pals_ico'];?>" onerror="parent.pic_error(this)" width="50px" height="50px" title="<?php echo $rs['pals_name'];?>" alt="<?php echo $rs['pals_name'];?>" />
				</a>
				<div><a href="home2.0.php?h=<?php echo $rs['pals_id'];?>" target="_blank">
						<?php echo sub_str($rs['pals_name'],5,true);?>
				</a></div>
				<div>
				<?php if($rs['to_user_id'] || $rs['user_id']){?>
					<?php echo $ef_langpackage->ef_invited;?>
				<?php }?>
				<?php if(!$rs['to_user_id'] && !$rs['user_id']){?>
					<input type="checkbox" name="pals_id[]" value="<?php echo $rs['pals_id'];?>" /><?php echo $ef_langpackage->ef_selected;?>
					<input type="hidden" name="pals_name[]" value="<?php echo $rs['pals_name'];?>" />
				<?php }?>
				</div>
			</div>
	<?php }?>
    <div class="clear"></div>
		<input type="submit" name="submit" value="<?php echo $ef_langpackage->ef_invite;?>" class="regular-btn" />
	</form>
<!--<?php echo page_show($isNull,$page_num,$page_total);?>!-->
<?php }?>

<div class="guide_info <?php echo $list_none;?>">
	<?php echo $no_event;?>
</div>
</body>
</html>