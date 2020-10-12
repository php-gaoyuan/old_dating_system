<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/event/event_member_manager.html
 * 如果您的模型要进行修改，请修改 models/modules/event/event_member_manager.php
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
	require("foundation/module_mypals.php");
	require("foundation/fpages_bar.php");
	require("api/base_support.php");
	
	//引入语言包
	$ef_langpackage=new event_frontlp;

	//变量区
	$role='';
	$user_id=get_sess_userid();
	$event_id=intval(get_argg('event_id'));
	$mod=intval(get_argg('mod'));

	//当前页面参数
	$page_num=trim(get_argg('page'));

	//权限判断
	$status=api_proxy("event_member_by_uid","status",$event_id,$user_id);
	$status=intval($status['status']);
	if($status < 3){
		echo "<script type='text/javascript'>alert(\"$ef_langpackage->ef_no_permission\");window.history.go(-1);</script>";
		exit();
	}
	
	switch($mod){
		case 0:
		//取得已经审核的成员
		$member_rs=api_proxy("event_member_by_eid","*",$event_id);		
		break;
		
		case 1:
		//取得关注的用户
		$member_rs=api_proxy("event_member_by_status","*",$event_id,1);		
		break;
		
		case 2:
		//取得未审核的成员
		$member_rs=api_proxy("event_member_by_status","*",$event_id,0);		
		break;
	}

	//显示控制
	$isNull=0;
	$list_none='content_none';
	if(empty($member_rs)){
		$list_none='';
		$isNull=1;
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
<div class="create_button"><a href="modules.php?app=event_info"><?php echo $ef_langpackage->ef_launch_activity;?></a></div>
<h2 class="app_event"><?php echo $ef_langpackage->ef_activity;?></h2>
<div class="tabs">
  <ul class="menu">
    <li><a href="modules.php?app=event_info&event_id=<?php echo $event_id;?>" hidefocus="true"><?php echo $ef_langpackage->ef_update_activity;?></a></li>
    <li class="active"><a href="modules.php?app=event_member_manager&event_id=<?php echo $event_id;?>" hidefocus="true"><?php echo $ef_langpackage->ef_member_management;?></a></li>
	<li><a href="modules.php?app=event_upload_photo&event_id=<?php echo $event_id;?>" hidefocus="true"><?php echo $ef_langpackage->ef_upload_photo;?></a></li>
  </ul>
</div>
<div class="search_friend">
	<select onchange="location.href='modules.php?app=event_member_manager&event_id=<?php echo $event_id;?>&mod='+this.value;">
		<option value='0' <?php echo $mod==0 ? 'selected':'';?>><?php echo $ef_langpackage->ef_participate_activity;?></option>
		<option value='1' <?php echo $mod==1 ? 'selected':'';?>><?php echo $ef_langpackage->ef_attention_activity;?></option>
		<option value='2' <?php echo $mod==2 ? 'selected':'';?>><?php echo $ef_langpackage->ef_need_review;?></option>
	</select>
</div>
<?php if($mod==0){?>
<div class="rs_head"><?php echo $ef_langpackage->ef_full_member;?></div>
<table class="msg_inbox" cellspacing="1" cellpadding="1">
	<thead>
		<tr>
			<td><?php echo $ef_langpackage->ef_name;?></td>
			<td><?php echo $ef_langpackage->ef_sex;?></td>
			<td><?php echo $ef_langpackage->ef_identity;?></td>
			<td><?php echo $ef_langpackage->ef_operation;?></td>
		</tr>
  </thead>
	<?php foreach($member_rs as $rs){?>

		<?php $act_show=show_manage_act($event_id,$status,$rs['status']);?>

    <tr>
    	<td><?php echo $rs['user_name'];?></td>
    	<td><?php echo get_pals_sex($rs['user_sex']);?></td>
    	<td><?php echo get_member_status($rs['status']);?></td>
    	<td>
    		<a href="home2.0.php?h=<?php echo $rs['user_id'];?>" target="_blank"><?php echo $ef_langpackage->ef_select;?></a>
				<span class="<?php echo $act_show['b_del'];?>">|&nbsp <a href="do.php?act=event_del_member&member_id=<?php echo $rs['user_id'];?>&event_id=<?php echo $event_id;?>" onclick='return confirm("<?php echo $ef_langpackage->ef_confirm_delete;?>")'><?php echo $ef_langpackage->ef_delete;?></a></span>
				<span class="<?php echo $act_show['b_app'];?>">|&nbsp <a href="do.php?act=event_appoint&member_id=<?php echo $rs['user_id'];?>&event_id=<?php echo $event_id;?>"><?php echo $ef_langpackage->ef_set_organizer;?></a> </span>
				<span class="<?php echo $act_show['b_rev'];?>">|&nbsp <a href="do.php?act=event_revoke&member_id=<?php echo $rs['user_id'];?>&event_id=<?php echo $event_id;?>"><?php echo $ef_langpackage->ef_revocation_organizer;?></a></span>
    	</td>
    </tr>

  <?php }?>

</table>
<?php }?>

<?php if($mod==1){?>
<div class="rs_head"><?php echo $ef_langpackage->ef_concerned_user;?></div>
<table class="msg_inbox" cellspacing="1" cellpadding="1">
	<?php foreach($member_rs as $rs){?>
	<tr>
		<td><?php echo $rs['user_name'];?></td>
		<td><?php echo get_pals_sex($rs['user_sex']);?></td>
		<td><?php echo $ef_langpackage->ef_failed;?></td>
		<td><?php echo date('Y-m-d :H:i:s',$rs['dateline']);?></td>
		<td>
			<a href="home2.0.php?h=<?php echo $rs['user_id'];?>" target="_blank"><?php echo $ef_langpackage->ef_select;?></a>
		</td>
	</tr>
	<?php }?>
</table>
<?php }?>

<?php if($mod==2){?>
<div class="rs_head"><?php echo $ef_langpackage->ef_pending_member;?></div>
<table class="msg_inbox" cellspacing="1" cellpadding="1">
	<?php foreach($member_rs as $rs){?>
	<tr>
		<td><?php echo $rs['user_name'];?></td>
		<td><?php echo get_pals_sex($rs['user_sex']);?></td>
		<td><?php echo $ef_langpackage->ef_failed;?></td>
		<td><?php echo date('Y-m-d :H:i:s',$rs['dateline']);?></td>

		<td>
			<a href="do.php?act=event_approve&member_id=<?php echo $rs['user_id'];?>&event_id=<?php echo $event_id;?>"><?php echo $ef_langpackage->ef_verify_join;?></a>&nbsp|&nbsp
			<a href="do.php?act=event_del_req&member_id=<?php echo $rs['user_id'];?>&event_id=<?php echo $event_id;?>"><?php echo $ef_langpackage->ef_delete;?></a>&nbsp|&nbsp
			<a href="home2.0.php?h=<?php echo $rs['user_id'];?>" target="_blank"><?php echo $ef_langpackage->ef_select;?></a>
		</td>
	</tr>
	<?php }?>
</table>
<?php }?>

<?php echo page_show($isNull,$page_num,$page_total);?>

<div class="guide_info <?php echo $list_none;?>">
	<?php echo $ef_langpackage->ef_data_none;?>
</div>

</body>
</html>