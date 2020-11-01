<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/event/event_list.html
 * 如果您的模型要进行修改，请修改 models/modules/event/event_list.php
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

	//表定义
	$t_event=$tablePreStr."event";
	$t_event_invite=$tablePreStr."event_invite";
	$t_event_members=$tablePreStr."event_members";
 
	//变量区
	$page_num=trim(get_argg('page'));
	$ses_uid=get_sess_userid();
	$mod=get_argg('mod');
	$event_rs=array();
	$list_none='';
	$mod_all='';
	$mod_recom='';
	$mod_city='';
	$no_event=''; 
	$sql='';
	$page_total='';
	$event_id_str='';
	
	//读定义
	dbtarget('r',$dbServs);
	$dbo=new dbex;
	
	switch($mod){
		case "all":
		$event_id_str = get_show_event_id($dbo,$ses_uid);
		$spell_str='';
		if($event_id_str){
			$spell_str=" or event_id in ($event_id_str) ";
		}
		$sql="select * from $t_event where is_pass=1 and grade>=1 and (public >=1 $spell_str ) ";
		$mod_all="class=active";
		break;
		
		case "recom":
		$mod_recom="class=active";
		$sql="select * from $t_event where is_pass=1 and grade=2 and public = 2";
		break;
		
		case "city":
		$mod_city="class=active";
		$user_row=api_proxy('user_self_by_uid','reside_city',$ses_uid);
		$spell_str='';
		if($user_row['reside_city']){
			$event_id_str = get_show_event_id($dbo,$ses_uid);
			if($event_id_str){
				$spell_str=" or event_id in ($event_id_str) ";
			}
			$sql="select * from $t_event where is_pass=1 and grade>=1 and city='".$user_row['reside_city']."' and (public >=1 $spell_str ) ";
		}else{
			$no_event=$ef_langpackage->ef_set_live_city.', <a href="modules2.0.php?app=user_info">'.$ef_langpackage->ef_now_settings.'</a>';
		}
		break;
	}
	
	if($sql){
		$dbo->setPages(10,$page_num);//设置分页
		$event_rs=$dbo->getRs($sql." order by event_id desc "); //取得结果集
		$page_total=$dbo->totalPage; //分页总数		
	}

	$no_event=$no_event ? $no_event:$ef_langpackage->ef_no_related_activity;
	
	//数据显示控制
	$list_none="content_none";
	$isNull=0;
	if(empty($event_rs)){
		$list_none="";
		$isNull=1;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<SCRIPT language=JavaScript src="servtools/ajax_client/ajax.js"></SCRIPT>
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
</head>
<body id="iframecontent">
	<div class="create_button"><a href="modules2.0.php?app=event_search"><?php echo $ef_langpackage->ef_search_activity;?></a></div>
	<div class="create_button"><a href="modules2.0.php?app=event_info&act=add"><?php echo $ef_langpackage->ef_launch_activity;?></a></div>
  <h2 class="app_event"><?php echo $ef_langpackage->ef_activity;?></h2>
  <div class="tabs">
		<ul class="menu">
		  <li <?php echo $mod_all;?>><a href="modules2.0.php?app=event_list&mod=all" hidefocus="true"><?php echo $ef_langpackage->ef_all_activity;?></a></li>
		  <li <?php echo $mod_recom;?>><a href="modules2.0.php?app=event_list&mod=recom" hidefocus="true"><?php echo $ef_langpackage->ef_recommended_activity;?></a></li>
		  <li <?php echo $mod_city;?>><a href="modules2.0.php?app=event_list&mod=city" hidefocus="true"><?php echo $ef_langpackage->ef_same_city_activity;?></a></li>
		  <li><a href="modules2.0.php?app=event" hidefocus="true"><?php echo $ef_langpackage->ef_my_activity;?></a></li>
		</ul>
	</div>
	<?php foreach($event_rs as $rs){?>
		<div class="group_box" onmouseover="this.className = 'group_box_active';" onmouseout="this.className='group_box';">
			<div class="group_box_content">
				<div class="group_control">
					<a href='modules2.0.php?app=event_space&event_id=<?php echo $rs["event_id"];?>'><?php echo $ef_langpackage->ef_select_activity;?></a>
				</div>
				<div class="group_photo">
					<a href='modules2.0.php?app=event_space&event_id=<?php echo $rs["event_id"];?>'><img src="<?php echo $rs['poster'];?>" width='100px' height='100px' alt="<?php echo $rs['title'];?>" onerror="parent.pic_error(this)" /></a>
				</div>
				<dl class="group_list">
					<dt><a href='modules2.0.php?app=event_space&event_id=<?php echo $rs["event_id"];?>'><?php echo filt_word($rs['title']);?></a></dt>
					<dd><?php echo $ef_langpackage->ef_activity_time;?>：<?php echo date('m月d日 H:i',$rs['start_time']);?>-<?php echo date('m月d日 H:i',$rs['end_time']);?></dd>
					<dd><?php echo $ef_langpackage->ef_sponsor;?>：<a href='home2.0.php?h=<?php echo $rs["user_id"];?>' target="_blank"><?php echo filt_word($rs['user_name']);?></a></dd>
					<dd><?php echo $rs['view_num'];?>  <?php echo $ef_langpackage->ef_people_select;?>  <?php echo $rs['member_num'];?>  <?php echo $ef_langpackage->ef_people_participate;?> <?php echo $rs['follow_num'];?>  <?php echo $ef_langpackage->ef_people_attention;?></dd>
				</dl>
			</div>
		</div>
	<?php }?>
  <div class="clear"></div>
  <?php echo page_show($isNull,$page_num,$page_total);?>
  
	<div class="guide_info <?php echo $list_none;?>">
		<?php echo $no_event;?> 
	</div>
	
</body>
</html>