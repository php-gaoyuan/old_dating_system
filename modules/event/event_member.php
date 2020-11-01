<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/event/event_member.html
 * 如果您的模型要进行修改，请修改 models/modules/event/event_member.php
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
	$ses_uid=get_sess_userid();
	$url_uid = intval(get_argg('user_id'));
	$event_id = intval(get_argg('event_id'));
	$send_script_js="location.href='modules2.0.php?app=msg_creator&2id={uid}&nw=1';";
	$send_join_js="mypals_add({uid});";
	$target="frame_content";
	
	//引入模块公共权限过程文件
	$is_self_mode = 'partLimit';
	$is_login_mode = '';
	require("foundation/auser_validate.php");
	
	$status=api_proxy("event_member_by_uid","status",$event_id,$ses_uid);
	$status=intval($status['status']);
	
	
	$event_rs=array();
	//取得活动成员
	$event_members = api_proxy("event_member_by_eid","*",$event_id);

	//数据显示控制
	$isNull=0;
	if(empty($event_members)){
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
<SCRIPT language=JavaScript src="servtools/ajax_client/ajax.js"></SCRIPT>
<script type='text/javascript'>
function mypals_add_callback(content,other_id){
	if(content=="success"){
		parent.Dialog.alert("<?php echo $mp_langpackage->mp_suc_add;?>");
		document.getElementById("operate_"+other_id).innerHTML="<?php echo $mp_langpackage->mp_suc_add;?>";
	}else{
		parent.Dialog.alert(content);
		document.getElementById("operate_"+other_id).innerHTML=content;
	}
}

function mypals_add(other_id){
	var mypals_add=new Ajax();
	mypals_add.getInfo("do.php","get","app","act=add_mypals&other_id="+other_id,function(c){mypals_add_callback(c,other_id);}); 
}
</script>
</head>

<body id="iframecontent">
<?php if($is_self=='Y'){?>
<div class="create_button">
	<a href="modules2.0.php?app=event_list&mod=all" hidefocus="true"><?php echo $ef_langpackage->ef_all_activity;?></a>
</div>
<?php }?>
<?php if($status>2 && $is_self=='Y'){?>
<div class="create_button">
	<a href="modules2.0.php?app=event_upload_photo&event_id=<?php echo $event_id;?>" hidefocus="true"><?php echo $ef_langpackage->ef_upload_photo;?></a>
</div>
<?php }?>
<h2 class="app_event"><?php echo $ef_langpackage->ef_activity;?></h2>
<div class="tabs">
	<ul class="menu">
		<li><a href="modules2.0.php?app=event_space&event_id=<?php echo $event_id;?>&user_id=<?php echo $userid;?>" hidefocus="true"><?php echo $ef_langpackage->ef_activity;?></a></li>
		<li class="active"><a href="modules2.0.php?app=event_member&event_id=<?php echo $event_id;?>&user_id=<?php echo $userid;?>" hidefocus="true"><?php echo $ef_langpackage->ef_member;?></a></li>
		<li><a href="modules2.0.php?app=event_list_photo&event_id=<?php echo $event_id;?>&user_id=<?php echo $userid;?>" hidefocus="true"><?php echo $ef_langpackage->ef_photo;?></a></li>
	</ul>
</div>

<?php foreach($event_members as $rs){?>
<div class="pals_list" onmouseover="this.className += ' pals_list_active';" onmouseout="this.className='pals_list';">
	<div class="right">
		<p id='operate_<?php echo $rs["user_id"];?>'>
		<a href=javascript:<?php echo $ses_uid ? str_replace("{uid}",$rs['user_id'],$send_join_js):'parent.goLogin();';?>><?php echo str_replace("{he}",get_TP_pals_sex($rs['user_sex']),$mp_langpackage->mp_add_mypals);?></a>
		</p>
		<a href=javascript:<?php echo $ses_uid ? str_replace("{uid}",$rs['user_id'],$send_script_js):'parent.goLogin();';?> target="<?php echo $target;?>"><?php echo str_replace("{he}",get_TP_pals_sex($rs['user_sex']),$mp_langpackage->mp_scrip);?></a>
	</div>
	<div class="avatar">
		<a href="home2.0.php?h=<?php echo $rs['user_id'];?>" target="_blank"><img src="<?php echo $rs['user_ico'];?>" onerror="parent.pic_error(this)" alt="<?php echo $rs['user_name'];?>" title='<?php echo $mp_langpackage->mp_sex;?>:<?php echo get_pals_sex($rs['user_sex']);?>' /></a>
	</div>
	<dl>
	  <dd><?php echo $mp_langpackage->mp_name;?>：<?php echo filt_word($rs["user_name"]);?></dd>
		<dd><?php echo $mp_langpackage->mp_reside;?>：<?php echo get_manage_reside($rs['reside_province'],$rs['reside_city']);?></dd>
	  <dd><?php echo $ef_langpackage->ef_identity;?>：<?php echo get_member_status($rs['status']);?></dd>
	</dl>
</div>
<?php }?>
<div class="clear"></div>
<?php echo page_show($isNull,$page_num,$page_total);?>
</body>
</html>