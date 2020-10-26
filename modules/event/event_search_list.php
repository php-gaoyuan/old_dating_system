<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/event/event_search_list.html
 * 如果您的模型要进行修改，请修改 models/modules/event/event_search_list.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
	//引入模块公共权限过程文件
	require("foundation/fpages_bar.php");
	require("foundation/module_event.php");
	require("api/base_support.php");

	//引入语言包
	$ef_langpackage=new event_frontlp;
	
	$event_name=short_check(get_argg('event_name'));
	$province=short_check(get_argg('province'));
	$city=short_check(get_argg('city'));
	$start_time1=short_check(get_argg("start_time1"));$start_time1=$start_time1 ? strtotime($start_time1):0;
	$start_time2=short_check(get_argg("start_time2"));$start_time2=$start_time2 ? strtotime($start_time2):0;
	$deadline1=short_check(get_argg("deadline1"));$deadline1=$deadline1 ? strtotime($deadline1):0;
	$deadline2=short_check(get_argg("deadline2"));$deadline2=$deadline2 ? strtotime($deadline2):0;
	$type_id=intval(get_argg('type_id'));

	$cols="";
	$ses_uid=get_sess_userid();
	$page_num=trim(get_argg('page'));
	$no_event = "";
	$mod_all = "";
	$mod_recom = "";
	$mod_city = "";
	$event_rs=array();

	//表定义
	$t_event=$tablePreStr."event";
	$t_event_invite=$tablePreStr."event_invite";
	
	//读定义
	dbtarget('r',$dbServs);
	$dbo=new dbex;
	
	if($event_name!=''){
		$cols.=" and title like '%$event_name%' ";
	}
	
	if($province!=''){
		$cols.=" and (province like '%$province%') ";
	}

	
	if($city!=''){
		$cols.=" and (city like '%$city%') ";
	}
		
	if($deadline1 && $deadline2){
		$cols.=" and deadline BETWEEN $deadline1 and $deadline2 ";
	}

	if($start_time1 && $start_time2){
		$cols.=" and start_time BETWEEN $start_time1 and $start_time2 ";
	}
	
	if($type_id){
		$cols.=" and type_id = $type_id ";
	}
	
	$event_id_str = get_show_event_id($dbo,$ses_uid);
	$event_id_str=$event_id_str?" or event_id in ($event_id_str) ":"";
	$sql="select * from $t_event where is_pass=1 and grade>=1 and (public >=1 $event_id_str ) $cols ";

	if($sql){
		$dbo->setPages(10,$page_num);//设置分页
		$event_rs=$dbo->getRs($sql); //取得结果集
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
	?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<SCRIPT language=JavaScript src="servtools/ajax_client/ajax.js"></SCRIPT>
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
</head>
<body id="iframecontent">
	<div class="create_button"><a href="modules2.0.php?app=event_search"><?php echo $ef_langpackage->ef_search_activity;?></a></div>
	<div class="create_button"><a href="modules2.0.php?app=event_info"><?php echo $ef_langpackage->ef_launch_activity;?></a></div>
    <h2 class="app_event"><?php echo $ef_langpackage->ef_activity;?></h2>
    <div class="tabs">
        <ul class="menu">
            <li class="active"><a href="modules2.0.php?app=event_list&mod=all" hidefocus="true"><?php echo $ef_langpackage->ef_search_activity;?></a></li>
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
					<dd><?php echo $ef_langpackage->ef_sponsor;?>：<a href='home2.0.php?h=<?php echo $rs["user_name"];?>' target="_blank"><?php echo filt_word($rs['user_name']);?></a></dd>
					<dd><?php echo $rs['view_num'];?> <?php echo $ef_langpackage->ef_people_select;?> <?php echo $rs['member_num'];?> <?php echo $ef_langpackage->ef_people_participate;?> <?php echo $rs['follow_num'];?> <?php echo $ef_langpackage->ef_people_attention;?></dd>
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