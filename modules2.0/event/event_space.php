<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/event/event_space.html
 * 如果您的模型要进行修改，请修改 models/modules/event/event_space.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
	//引入公共模块
	require("foundation/fpages_bar.php");
	require("foundation/module_event.php");
	require("foundation/fcontent_format.php");
	require("api/base_support.php");
	
	//引入语言包
	$ef_langpackage=new event_frontlp;
	
	//变量区
	$dbo=new dbex;
	$url_uid = intval(get_argg('user_id'));
	$ses_uid = get_sess_userid();
	$is_admin = get_sess_admin();
	$event_id = intval(get_argg('event_id'));
	$event_members = array();
	$event_row = array();
	$photo_rs = array();
	$is_join='';
	$is_join_event='';
	$is_doing='';
	$is_doing_event='';
	$join_js='';
	$time=time();
	$error_str=$ef_langpackage->ef_activity_not_exist_canceled;
	$is_show=0;
	
	//引入模块公共权限过程文件
	$is_self_mode = 'partLimit';
	$is_login_mode = '';
	require("foundation/auser_validate.php");

	//取得活动信息
	$event_row = api_proxy("event_self_by_eid","*",$event_id);
	if(!empty($event_row)){

		if(($event_row['is_pass']=='1' && $event_row['grade']>='1') || $event_row['user_id']==$ses_uid || $is_admin){
			$is_show=1;
			
			//取得活动成员
			$event_members = api_proxy("event_member_by_eid","*",$event_id,10);
			
			$user_row=api_proxy("event_member_by_uid","status,fellow,template",$event_id,$ses_uid);
			
			$is_join=$user_row['status'];
			if($is_join>1){
				$is_join_event = $ef_langpackage->ef_participated_activity;
			}else if($is_join===0){
				$is_join_event = $ef_langpackage->ef_your_app_audit;
			}else if($is_join==1){
				$is_join_event = $ef_langpackage->ef_attented_activity;
			}
			if($time<$event_row['start_time']){
				$is_doing=1;
				$is_doing_event=$ef_langpackage->ef_activity_not_start;
			}else if($time>=$event_row['start_time'] && $time<$event_row['end_time']){
				$is_doing=2;
				$is_doing_event=$ef_langpackage->ef_activity_ongoing;
			}else{
				$is_doing=0;
				$is_doing_event=$ef_langpackage->ef_activity_already_end;
			}
			
			//活动照片
			$t_event_photo=$tablePreStr."event_photo";
			$sql="select photo_id,photo_name,photo_thumb_src from $t_event_photo where event_id=$event_id limit 8";
			$photo_rs=$dbo->getRs($sql);
			
			$event_row['template'] = str_replace(array("\r\n","\n","\r"),"<br>",$event_row['template']);
			$user_row['template'] = str_replace(array("\r\n","\n","\r"),"<br>",$user_row['template']);
		
			//查看计数
			if($ses_uid!=getCookie('e_'.$event_id)){
				  //读写分离方法-写操作
				  dbtarget('w',$dbServs);
				  $t_event=$tablePreStr."event";
				  $sql="update $t_event set view_num=view_num+1 where event_id=$event_id";
				  $dbo->exeUpdate($sql);
				  set_cookie('e_'.$event_id,$ses_uid);
			}
			
			$status=api_proxy("event_member_by_uid","status",$event_id,$ses_uid);
			$status=intval($status['status']);
			
			
		}else{
			$error_str=$ef_langpackage->ef_activity_not_approved_locked;
		}
	}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
<script type='text/javascript' src="skin/default/js/jooyea.js"></script>
<script type="text/javascript" src="servtools/imgfix.js"></script>
<SCRIPT language=JavaScript src="servtools/ajax_client/ajax.js"></SCRIPT>
<script type='text/javascript'>parent.hiddenDiv();</script>
<script language="JavaScript">
function join_action(event_id,allow_fellow,template){
	var is_class='';
	template=template.replace(/<br>/gi,'\r\n');
	var fellow_class='content_none';
	var template_class='content_none';
	var diag = new parent.Dialog();
	diag.Width = 320;
	diag.Height = 150;
	diag.Top="50%";
	diag.Left="50%";
	diag.Title = "<?php echo $ef_langpackage->ef_fill_in_reg_info;?>";
	if(allow_fellow==1){
		fellow_class='';
		is_class='content_none';
	}
	if(template){
		template_class='';
		is_class='content_none';
	}
	diag.InnerHtml= '<div class="report_notice"><div class='+is_class+'><?php echo $ef_langpackage->ef_confirm_participate;?></div><div class='+fellow_class+'><?php echo $ef_langpackage->ef_carry_number;?><input id="fellow" name="fellow" size="2" value="0" /><?php echo $ef_langpackage->ef_carrying_tips;?></div><div class='+template_class+'><?php echo $ef_langpackage->ef_reg_info;?><?php echo $ef_langpackage->ef_reg_info_Tips;?><textarea id="template">'+template+'</textarea></div></div>';
	diag.OKEvent = function(){join_event(event_id,parent.document.getElementById('fellow').value,parent.document.getElementById('template').value);diag.close();};
	diag.show();
}

function join_event(event_id,fellow,template){
	var event_add=new Ajax();
	event_add.getInfo("do.php?act=event_join","post","app","event_id="+event_id+"&fellow="+fellow+"&template="+template,function(c){parent.Dialog.alert(c);location.href="modules.php?app=event_space&event_id="+event_id});
}


function edit_apply_action(event_id,allow_fellow,template,my_template,fellow){
	var is_return=1;
	var fellow_class='content_none';
	var template_class='content_none';
	var diag = new parent.Dialog();
	diag.Width = 320;
	diag.Height = 150;
	diag.Top="50%";
	diag.Left="50%";
	diag.Title = "<?php echo $ef_langpackage->ef_update_reg_info;?>";
	if(allow_fellow=='1'){
		fellow_class='';
		is_return=0;
	}
	if(template){
		template_class='';
		my_template=my_template?my_template:template;
		is_return=0;
	}
	if(is_return){
		parent.Dialog.alert('<?php echo $ef_langpackage->ef_this_no_reg_info;?>');return;
	}
	diag.InnerHtml= '<div class="report_notice"><div class='+fellow_class+'><?php echo $ef_langpackage->ef_carry_number;?><input id="fellow" name="fellow" size="2" value="'+fellow+'" /><?php echo $ef_langpackage->ef_carrying_tips;?></div><div class='+template_class+'><?php echo $ef_langpackage->ef_reg_info;?><?php echo $ef_langpackage->ef_reg_info_Tips;?><textarea id="template">'+ my_template.replace(/<br>/gi,'\r\n') +'</textarea></div></div>';
	diag.OKEvent = function(){event_edit_apply(event_id,parent.document.getElementById('fellow').value,parent.document.getElementById('template').value);diag.close();};
	diag.show();
}
function event_edit_apply(event_id,fellow,template){
	var event_add=new Ajax();
	event_add.getInfo("do.php?act=event_edit_apply","post","app","event_id="+event_id+"&fellow="+fellow+"&template="+template,function(c){parent.Dialog.alert(c);location.href="modules.php?app=event_space&event_id="+event_id});
}


function event_exit(event_id){
	var event_add=new Ajax();
	event_add.getInfo("do.php","get","app","act=event_exit&event_id="+event_id,function(c){if(c!="") parent.Dialog.alert(c);location.href="modules.php?app=event_space&event_id="+event_id});
}
function event_follow_cancel(event_id){
	var event_follow=new Ajax();
	event_follow.getInfo("do.php","get","app","act=event_follow_cancel&event_id="+event_id,function(c){if(c!="") parent.Dialog.alert(c);location.href="modules.php?app=event_space&event_id="+event_id});
}
</script>
</head>

<body id="iframecontent">
<?php if($is_self=='Y'){?>
<div class="create_button"><a href="modules.php?app=event_list&mod=all" hidefocus="true"><?php echo $ef_langpackage->ef_all_activity;?></a></div>
<?php }?>
<?php if($status>2 && $is_self=='Y'){?>
<div class="create_button">
	<a href="modules.php?app=event_upload_photo&event_id=<?php echo $event_id;?>" hidefocus="true"><?php echo $ef_langpackage->ef_upload_photo;?></a>
</div>
<?php }?>
<h2 class="app_event"><?php echo $ef_langpackage->ef_activity;?></h2>
<?php if($is_show){?>
<div class="tabs">
	<ul class="menu">
		<li class="active"><a href="modules.php?app=event_space&event_id=<?php echo $event_id;?>&user_id=<?php echo $userid;?>" hidefocus="true"><?php echo $ef_langpackage->ef_activity;?></a></li>
		<li><a href="modules.php?app=event_member&event_id=<?php echo $event_id;?>&user_id=<?php echo $userid;?>" hidefocus="true"><?php echo $ef_langpackage->ef_member;?></a></li>
		<li><a href="modules.php?app=event_list_photo&event_id=<?php echo $event_id;?>&user_id=<?php echo $userid;?>" hidefocus="true"><?php echo $ef_langpackage->ef_photo;?></a></li>
	</ul>
</div>

	<div class="evt_box">
		<div class="evt_ico"><a href="<?php echo $event_row['poster'];?>" hidefocus="true" target="_blank"><img height="150" onerror="this.src='uploadfiles/event/default_event_poster.jpg';" src="<?php echo $event_row['poster_thumb'];?>" /></a></div>
        <div class="evt_cnt">
            <table cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                	<th><?php echo $ef_langpackage->ef_sponsor;?>:</th><td><?php echo $event_row['user_name'];?></td>
                </tr>
                <tr>
                	<th><?php echo $ef_langpackage->ef_activity_type;?>:</th><td><?php echo event_type($dbo,$event_row['type_id']);?></td>
                </tr>
                <tr>
                	<th><?php echo $ef_langpackage->ef_activity_location;?>:</th><td><?php echo get_manage_reside($event_row['province'],$event_row['city']);?> <?php echo $event_row['location'];?></dd></td></tr>
                <tr>
                	<th><?php echo $ef_langpackage->ef_activity_time;?>:</th><td><?php echo date('m月d日 H:i',$event_row['start_time']);?> - <?php echo date('m月d日 H:i',$event_row['end_time']);?></td>
                </tr>
                <tr>
                	<th><?php echo $ef_langpackage->ef_closing;?>:</th><td><?php echo date('m月d日 H:i',$event_row['deadline']);?></td>
                </tr>
                <tr>
                	<th><?php echo $ef_langpackage->ef_activity_number;?>:</th><td><?php echo event_limit_num($event_row['limit_num'],$event_row['member_num']);?></td>
                </tr>
                <tr>
                	<th><?php echo $ef_langpackage->ef_need_review;?>:</th><td><?php echo $event_row['public']==0?"不需要":"需要";?></td>
                </tr>
            </table>
            <ul>
                <li><?php echo $event_row['view_num'];?> <?php echo $ef_langpackage->ef_people_select;?></li><li><?php echo $event_row['member_num'];?> <?php echo $ef_langpackage->ef_people_participate;?></li><li><?php echo $event_row['follow_num'];?> <?php echo $ef_langpackage->ef_people_attention;?></li>
            </ul>
            <p class="evt_state"><?php echo $is_join_event;?> <?php echo $is_doing_event;?></p>
            <ul class="buttons">
            <?php if($is_doing){?>
						<?php if($is_join>1){?>
							<?php if($event_row['allow_invite']=='1'){?>
							<li><a class="regular-btn" href="modules.php?app=event_invite&event_id=<?php echo $event_id;?>"><?php echo $ef_langpackage->ef_invite_friends;?></a></li>
							<?php }?>
							<?php if($event_row['allow_fellow']=='1' || $event_row['template']){?>
              <li><a class="regular-btn" href="javascript:void(0);"onclick="edit_apply_action(<?php echo $event_id;?>,<?php echo $event_row['allow_fellow'];?>,'<?php echo $event_row['template'];?>','<?php echo $user_row['template'];?>',<?php echo $user_row['fellow'];?>);"><?php echo $ef_langpackage->ef_reg_info;?></a></li>
							<?php }?>
							<li><a class="regular-btn" href="javascript:void(0);" onclick="if(confirm('<?php echo $ef_langpackage->ef_confirm_exit;?>')){event_exit(<?php echo $event_id;?>);}"><?php echo $ef_langpackage->ef_exit_activity;?></a></li>
						<?php }?>
						<?php if($is_join==1){?>
              <li><a class="regular-btn" href="javascript:void(0);" onclick="join_action(<?php echo $event_id;?>,<?php echo $event_row['allow_fellow'];?>,'<?php echo $event_row['template'];?>');"><?php echo $ef_langpackage->ef_participate_activity;?></a></li>
              <li><a class="regular-btn" href="javascript:void(0);" onclick="if(confirm('<?php echo $ef_langpackage->ef_confirm_cancel;?>')){event_follow_cancel(<?php echo $event_id;?>);}"><?php echo $ef_langpackage->ef_cancel_concern;?></a></li>
						<?php }?>
						<?php if($is_join==='0'){?>
							<?php if($event_row['allow_fellow']=='1' || $event_row['template']){?>
              <li><a class="regular-btn" href="javascript:void(0);"onclick="edit_apply_action(<?php echo $event_id;?>,<?php echo $event_row['allow_fellow'];?>,'<?php echo $event_row['template'];?>','<?php echo $user_row['template'];?>',<?php echo $user_row['fellow'];?>);"><?php echo $ef_langpackage->ef_reg_info;?></a></li>
							<?php }?>
              <li><a class="regular-btn" href="javascript:void(0);" onclick="if(confirm('<?php echo $ef_langpackage->ef_confirm_exit;?>')){event_exit(<?php echo $event_id;?>);}"><?php echo $ef_langpackage->ef_exit_activity;?></a></li>
						<?php }?>
						<?php if(!$is_join && $is_join!=='0' && $ses_uid){?>
							<li><a class="regular-btn" href="javascript:void(0);" onclick="join_action(<?php echo $event_id;?>,<?php echo $event_row['allow_fellow'];?>,'<?php echo $event_row['template'];?>');"><?php echo $ef_langpackage->ef_participate_activity;?></a></li>
							<li><a class="regular-btn" href="do.php?act=event_follow&event_id=<?php echo $event_id;?>"><?php echo $ef_langpackage->ef_attention_activity;?></a></li>
						<?php }?>
					<?php }?>
					<?php if($is_self=='Y' && $is_join>=3){?>
						<li><a class="regular-btn" href="modules.php?app=event_info&event_id=<?php echo $event_id;?>"><?php echo $ef_langpackage->ef_activity_management;?></a></li>
					<?php }?>
            </ul>

        </div>
<div class="rs_head"><?php echo $ef_langpackage->ef_activity_introduction;?></div>
<div class="evt_detail"><?php echo $event_row['detail'];?></div>
<div class="rs_head">
	<a class="right" href="modules.php?app=event_member&event_id=<?php echo $event_id;?>&user_id=<?php echo $userid;?>"><?php echo $ef_langpackage->ef_more;?></a><?php echo $ef_langpackage->ef_activity_members;?>
</div>

<?php foreach($event_members as $rs){?>
<div class="group_user_list">
    <a class="avatar" href="home2.0.php?h=<?php echo $rs['user_id'];?>" target="_blank">
        <img src="<?php echo $rs['user_ico'];?>" onerror="parent.pic_error(this)" width="50px" height="50px" title="<?php echo $rs['user_name'];?>" alt="<?php echo $rs['user_name'];?>" />
    </a>
  <div><a href="home2.0.php?h=<?php echo $rs['user_id'];?>" target="_blank"><?php echo sub_str($rs['user_name'],5,true);?></a></div>
</div>
<?php }?>

<div class="rs_head">
	<a class="right" href="modules.php?app=event_list_photo&event_id=<?php echo $event_id;?>&user_id=<?php echo $userid;?>"><?php echo $ef_langpackage->ef_more;?></a><?php echo $ef_langpackage->ef_album;?>
</div>

<?php foreach($photo_rs as $rs){?>
<div class="evt_album">
	<a href="modules.php?app=event_show_photo&event_id=<?php echo $event_id;?>&photo_id=<?php echo $rs['photo_id'];?>&user_id=user_id=<?php echo $url_uid;?>">
		<img src="<?php echo $rs['photo_thumb_src'];?>" onerror="parent.pic_error(this)" title="<?php echo $rs['photo_name'];?>" alt="<?php echo $rs['photo_name'];?>" />
	</a>
</div>
<?php }?>

<div class="rs_head"><?php echo $ef_langpackage->ef_message;?></div><div class="tleft ml20">

<div class="comment">

	<div id='show_7_<?php echo $event_row["event_id"];?>'>
	  <script type='text/javascript'>parent.get_mod_com(7,<?php echo $event_row['event_id'];?>,0,20);</script>
	</div>

	<?php if($ses_uid!=''){?>
		<?php if($event_row['allow_post'] == 1 || ($event_row['allow_post'] == 0 && $status >= 2)){?>
		<div class="reply">
			<img class="figure" src="<?php echo get_sess_userico();?>" />
			<p><textarea type="text" maxlength="150" onkeyup="return isMaxLen(this)" id="reply_7_<?php echo $event_row['event_id'];?>_input"></textarea></p>
			<div class="replybt">
				<input class="left button" onclick="parent.restore_com(<?php echo $event_row['user_id'];?>,7,<?php echo $event_row['event_id'];?>);show('face_list_menu',200)" type="submit" name="button" id="button" value="<?php echo $ef_langpackage->ef_reply;?>" />
				<a id="reply_a_<?php echo $event_row['event_id'];?>_input" class="right" href="javascript:void(0);" onclick="showFace(this,'face_list_menu','reply_7_<?php echo $event_row['event_id'];?>_input');"><?php echo $ef_langpackage->ef_expression;?></a>
			</div>
			<div class="clear"></div>
		</div>
		<?php }?>
	<?php }?>

</div>
<?php }?>
</div>
<?php if(!$is_show){?>
<div class="guide_info" >
	<?php echo $error_str;?>
</div>
<?php }?>
<!-- face begin -->
<div id="face_list_menu" class="emBg" style="display:none;z-index:100;"></div>
<!-- face end -->

</body>
</html>