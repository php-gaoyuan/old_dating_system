<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/event/event_list_photo.html
 * 如果您的模型要进行修改，请修改 models/modules/event/event_list_photo.php
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
	$page_num=intval(get_argg('page'));
	$ses_uid=get_sess_userid();
	$url_uid = intval(get_argg('user_id'));
	$event_id = intval(get_argg('event_id'));
	$photo_rs=array();
	
	//引入模块公共权限过程文件
	$is_self_mode = 'partLimit';
	$is_login_mode = '';
	require("foundation/auser_validate.php");
	
  //数据表定义
  $t_event_photo=$tablePreStr."event_photo";
  
	//权限判断
	$status=api_proxy("event_member_by_uid","status",$event_id,$ses_uid);
	$status=intval($status['status']);  
		
	$dbo=new dbex;
	dbtarget('r',$dbServs);

	$dbo->setPages(20,$page_num);//设置分页
	$sql="select * from $t_event_photo where event_id=$event_id";
	$photo_rs = $dbo->getRs($sql);
	$page_total=$dbo->totalPage;//分页总数

	//数据显示控制
	$list_none="content_none";
	$isNull=0;
	if(empty($photo_rs)){
		$isNull=1;
		$list_none="";
	}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<SCRIPT language=JavaScript src="servtools/ajax_client/ajax.js"></SCRIPT>
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
</head>
<script language="JavaScript" type="text/JavaScript"> 
function check_form(obj){
	var obj_check=obj.getElementsByTagName('input');
	var is_check=false;
	for(i=0;i<obj_check.length;i++){
		if(obj_check[i].type=='checkbox'){
			if(obj_check[i].checked==true){
				is_check=true;
				break;
			}
		}
	}
	return is_check;
}

function checkAll(obj){
	var form_obj=document.getElementById(obj);
	var input_obj=form_obj.getElementsByTagName('input');
	for(i=0;i<input_obj.length;i++){
		if(input_obj[i].type=='checkbox'){
			if(input_obj[i].checked==true){
				input_obj[i].checked='';
			}else{
				input_obj[i].checked='checked';
			}
		}
	}
}
</script>
<body id="iframecontent">
	<?php if($is_self=='Y'){?>
	<div class="create_button">
		<div class="create_button"><a href="modules.php?app=event_list&mod=all" hidefocus="true"><?php echo $ef_langpackage->ef_all_activity;?></a></div>
	</div>
	<?php }?>
	<?php if($status>2 && $is_self=='Y'){?>
	<div class="create_button">
		<a href="modules.php?app=event_upload_photo&event_id=<?php echo $event_id;?>" hidefocus="true"><?php echo $ef_langpackage->ef_upload_photo;?></a>
	</div>
	<?php }?>
<form id="data_list" name="data_list" action="do.php?act=event_del_photo&event_id=<?php echo $event_id;?>" method="post" onsubmit="return check_form(this);">
  <h2 class="app_event"><?php echo $ef_langpackage->ef_activity;?></h2>
  <div class="tabs">
      <ul class="menu">
			<li><a href="modules.php?app=event_space&event_id=<?php echo $event_id;?>&user_id=<?php echo $userid;?>" hidefocus="true"><?php echo $ef_langpackage->ef_activity;?></a></li>
			<li><a href="modules.php?app=event_member&event_id=<?php echo $event_id;?>&user_id=<?php echo $userid;?>" hidefocus="true"><?php echo $ef_langpackage->ef_member;?></a></li>
			<li class="active"><a href="modules.php?app=event_list_photo&event_id=<?php echo $event_id;?>&user_id=<?php echo $userid;?>" hidefocus="true"><?php echo $ef_langpackage->ef_photo;?></a></li>
      </ul>
  </div>

	<?php foreach($photo_rs as $val){?>
	<div class="album_photo_box">
	  <a href="modules.php?app=event_show_photo&event_id=<?php echo $val['event_id'];?>&photo_id=<?php echo $val['photo_id'];?>&user_id=<?php echo $ses_uid;?>">
	  	<img src="<?php echo $val['photo_thumb_src'];?>" width="100px" class="user_ico" /></a><br />
			<?php echo $ef_langpackage->ef_come_from;?>：<?php echo $val['user_name'];?><br />
			<?php if($status>3){?>
	  	<input type="checkbox" class="checkbox" name="checkany[]" value="<?php echo $val['photo_id'];?>" />
	  	<?php }?>
	  </a>
	</div>
	<?php }?>
    <div class="clear"></div>
	<?php if($status > 3 && $photo_rs){?>
		<input class="regular-btn" style="font-size:12px" type="button" name="chkall" id="chkall" onclick="checkAll('data_list')" value="<?php echo $ef_langpackage->ef_select_all;?>" />
		<input class="regular-btn" style="font-size:12px" type="submit" id="RemoveAll" name="RemoveAll" value="<?php echo $ef_langpackage->ef_bulk_delete;?>" />
  <?php }?>
	<div class="clear"></div>
</form>
	<?php page_show($isNull,$page_num,$page_total);?>
	
	<div class="guide_info <?php echo $list_none;?>">
		<?php echo $ef_langpackage->ef_current_without_photo;?>
	</div>
	
</body>
</html>