<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/event/event_mine.html
 * 如果您的模型要进行修改，请修改 models/modules/event/event_mine.php
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
	require("foundation/module_users.php");
	require("foundation/fpages_bar.php");
	require("api/base_support.php");

	//引入语言包
	$ef_langpackage=new event_frontlp;

	//变量区
	$page_num=intval(get_argg('page'));
	$ses_uid=get_sess_userid();
	$url_uid = intval(get_argg('user_id'));
	$event_rs=array();
	$page_total='';
	
  //引入模块公共权限过程文件
	$is_self_mode='partLimit';
	$is_login_mode='';
	require("foundation/auser_validate.php");	
	
	if($is_self=='Y'){
		$str_title=$ef_langpackage->ef_activity;
	}else{
		$holder_name=get_hodler_name($url_uid);
		$str_title=str_replace("{holder}",$holder_name,'{holder}'.$ef_langpackage->ef_is_activity);
	}	

	//缓存功能区
	$event_rs = api_proxy("event_self_by_uid","*",$userid,"getRs");

	//数据显示控制
	$list_none="content_none";
	$isNull=0;
	if(empty($event_rs)){
		$isNull=1;
		$list_none="";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<SCRIPT language=JavaScript src="servtools/ajax_client/ajax.js"></SCRIPT>
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
<script language="JavaScript">
function event_exit(event_id){
	var event_add=new Ajax();
	event_add.getInfo("do.php","get","app","act=event_exit&event_id="+event_id,function(c){if(c!="") parent.Dialog.alert(c);location.href="modules.php?app=event"}); 
}
function event_follow_cancel(event_id){
	var event_follow=new Ajax();
	event_follow.getInfo("do.php","get","app","act=event_follow_cancel&event_id="+event_id,function(c){if(c!="") parent.Dialog.alert(c);location.href="modules.php?app=event"}); 
}
</script>
</head>
<body id="iframecontent">
	<?php if($is_self=='Y'){?>
	<div class="create_button"><a href="modules.php?app=event_search"><?php echo $ef_langpackage->ef_search_activity;?></a></div>
	<div class="create_button"><a href="modules.php?app=event_info"><?php echo $ef_langpackage->ef_launch_activity;?></a></div>
	<?php }?>
  <h2 class="app_event"><?php echo $str_title;?></h2>
  <?php if($is_self=='Y'){?>
  <div class="tabs">
    <ul class="menu">
      <li><a href="modules.php?app=event_list&mod=all" hidefocus="true"><?php echo $ef_langpackage->ef_all_activity;?></a></li>
      <li><a href="modules.php?app=event_list&mod=recom" hidefocus="true"><?php echo $ef_langpackage->ef_recommended_activity;?></a></li>
      <li><a href="modules.php?app=event_list&mod=city" hidefocus="true"><?php echo $ef_langpackage->ef_same_city_activity;?></a></li>
      <li class='active'><a href="modules.php?app=event" hidefocus="true"><?php echo $ef_langpackage->ef_my_activity;?></a></li>
    </ul>
  </div>
	<?php }?>
	<?php foreach($event_rs as $rs){?>
		<div class="group_box" onmouseover="this.className = 'group_box_active';" onmouseout="this.className='group_box';">
			<div class="group_box_content">
        <div class="group_control">
				<?php if($is_self=='Y'){?>
					<?php $action=show_action($rs['user_id'],$ses_uid,$rs['event_id']);?>
					<a class="<?php echo $action['manage'];?>" href="modules.php?app=event_info&event_id=<?php echo $rs['event_id'];?>"><?php echo $ef_langpackage->ef_activity_management;?></a>
					<a class="<?php echo $action['drop'];?>" href="do.php?act=event_drop&event_id=<?php echo $rs['event_id'];?>" onclick="return confirm('<?php echo $ef_langpackage->ef_confirm_cancel;?>');"><?php echo $ef_langpackage->ef_cancel_activity;?></a>
					<a class="<?php echo $action['exit'];?>" href="javascript:void(0);" onclick="if(confirm('<?php echo $ef_langpackage->ef_confirm_exit;?>')){event_exit(<?php echo $rs['event_id'];?>)};"><?php echo $ef_langpackage->ef_exit_activity;?></a>
					<a class="<?php echo $action['follow'];?>" href="javascript:void(0);" onclick="if(confirm('<?php echo $ef_langpackage->ef_confirm_cancel;?>')){event_follow_cancel(<?php echo $rs['event_id'];?>)};"><?php echo $ef_langpackage->ef_cancel_concern;?></a>
        <?php }?>
				</div>
				<div class="group_photo">
					<a href='modules.php?app=event_space&event_id=<?php echo $rs["event_id"];?>&user_id=<?php echo $url_uid;?>'><img src="<?php echo $rs['poster'];?>" width='100px' height='100px' alt="<?php echo $rs['title'];?>" onerror="parent.pic_error(this)" /></a>
				</div>
				<dl class="group_list">
					<dt><a href='modules.php?app=event_space&event_id=<?php echo $rs["event_id"];?>&user_id=<?php echo $url_uid;?>'><?php echo filt_word($rs['title']);?></a></dt>
					<dd><?php echo $ef_langpackage->ef_activity_time;?>：<?php echo date('m月d日 H:i',$rs['start_time']);?>-<?php echo date('m月d日 H:i',$rs['end_time']);?></dd>
					<?php if($is_self=='Y'){?>
					<dd><?php echo $ef_langpackage->ef_i_is;?>：<?php echo $action['status'];?></dd>
					<?php }?>
					<dd><?php echo $rs['view_num'];?> <?php echo $ef_langpackage->ef_people_select;?> <?php echo $rs['member_num'];?> <?php echo $ef_langpackage->ef_people_participate;?> <?php echo $rs['follow_num'];?> <?php echo $ef_langpackage->ef_people_attention;?></dd>
				</dl>
			</div>
		</div>
	<?php }?>
  <div class="clear"></div>
	<?php page_show($isNull,$page_num,$page_total);?>
	
	<div class="guide_info <?php echo $list_none;?>">
		<?php echo $ef_langpackage->ef_no_activity_you_can;?>
		<?php if($is_self=='Y'){?>
		<a href="modules.php?app=event_info"><?php echo $ef_langpackage->ef_initiate_activity;?></a>
		<?php }?>
	</div>
</body>
</html>