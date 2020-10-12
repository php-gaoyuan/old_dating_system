<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/event/event_show_photo.html
 * 如果您的模型要进行修改，请修改 models/modules/event/event_show_photo.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
	require("foundation/module_users.php");
	require("foundation/module_mypals.php");
	require("api/base_support.php");
		
	//引入语言包
	$ef_langpackage=new event_frontlp;
	$a_langpackage=new albumlp;
	
	//变量取得
	$photo_id = intval(get_argg('photo_id'));
	$event_id=intval(get_argg('event_id'));
	$prev_next = get_argg('prev_next');
	$url_uid= intval(get_argg('user_id'));
	$ses_uid=get_sess_userid();

	//引入模块公共权限过程文件
	$is_login_mode='';
	$is_self_mode='partLimit';
	require("foundation/auser_validate.php");

	//数据显示控制
	$show_data="";
	$show_error="content_none";
	$show_content="content_none";

	//数据表定义区
	$t_event_photo = $tablePreStr."event_photo";
	$t_users=$tablePreStr."users";
	$t_event=$tablePreStr."event";

	$album_info=array();
	$photo_row=array();
	
	$dbo=new dbex;
	dbtarget('r',$dbServs);	
	
	$sql="select title from $t_event where event_id=$event_id";
	$event_info=$dbo->getRow($sql);
	
	$a_who=($is_self=='Y') ? $ef_langpackage->ef_my_albums:str_replace('{holder}',filt_word(get_hodler_name($url_uid)),$ef_langpackage->ef_Holder_album);
		
	if($event_info){
		//查找相册信息
		$event_title=$event_info['title'];
		
		//权限判断
		$status=api_proxy("event_member_by_uid","status",$event_id,$ses_uid);
		$status=intval($status['status']);
		
		if($prev_next){
			$dbo = new dbex;
			//读写分离定义函数
			dbtarget('r',$dbServs);
			$sql = 'SELECT photo_id FROM '.$t_event_photo.' WHERE event_id = '.$event_id.' ORDER BY photo_id DESC';
			$photo_rs = $dbo->getRs($sql);
			$num = count($photo_rs);
			foreach($photo_rs AS $key=>$val)
			{
				if($val['photo_id'] == $photo_id)
				{
					$photo_id = $photo_rs[$prev_next === 'next' ? ($key == ($num - 1) ? 0 : $key + 1) : ($prev_next === 'prev' ? ($key == 0 ? $num - 1 : $key - 1) : 0)]['photo_id'];
					break;
				}
			}
		}
		$sql="select * from $t_event_photo where photo_id=$photo_id";
		$photo_row=$dbo->getRow($sql);
				
		//查找照片信息
		if($photo_row['photo_src']){
			$img_info=getimagesize($photo_row['photo_src']);
		}
		$photo_inf=$photo_row['photo_information'] ? $photo_row['photo_information']:$ef_langpackage->ef_update_photo_info;
	}else{
		$show_data="content_none";
		$show_error="";
	}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<base href='<?php echo $siteDomain;?>' />
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
<script type='text/javascript' src='servtools/ajax_client/ajax.js'></script>
<script type='text/javascript' src="skin/default/js/jooyea.js"></script>
<script type="text/javascript">
function change_photo_callback(content){
	var return_text=content;
	var return_text=return_text.replace(/[\s\n\r]/g,"");
	if(return_text==""){
	$("def_photo_info").innerHTML="<?php echo $a_langpackage->a_pht_inf;?>";}
	else{$("def_photo_info").innerHTML=return_text;}
	$("def_photo_info").style.display="";
	$("photo_info").style.display="none";
}
function change_photo(){
	var photo_id=$("photo_id").value;
	var photo_information_value=$("information_value").value;
	var change_photo=new Ajax();
	change_photo.getInfo("do.php?act=event_im_photo&photo_id=<?php echo $photo_id;?>&event_id=<?php echo $event_id;?>","post","app","photo_id="+photo_id+"&information_value="+photo_information_value,function(c){change_photo_callback(c);});
}

function change_state(){
	var return_text=$("def_photo_info").innerHTML;
	var return_text=return_text.replace(/[\s\n\r]/g,"");
	if(return_text=="<?php echo $a_langpackage->a_pht_inf;?>"){
		var information="";
	}else{
		var information=return_text;
	}
	$("information_value").value=information;
	$("def_photo_info").style.display="none";
	$("photo_info").style.display="";
}

function chancel(){
	$("def_photo_info").style.display="";
	$("photo_info").style.display="none";
}

function Get_mouse_pos(obj){
	var event=getEvent();
	if(navigator.appName=='Microsoft Internet Explorer'){
		return event.offsetX;
	}else if(navigator.appName=='Netscape'){
		return event.pageX-obj.offsetLeft;
	}
}
</script>
</head>
<body id="iframecontent">
	<div class="create_button"><a href="javascript:window.history.go(-1)"><?php echo $ef_langpackage->ef_back;?></a></div>
  <h2 class="app_event"><?php echo $ef_langpackage->ef_activity;?></h2>
  <div class="tabs">
    <ul class="menu">
		<li><a href="modules.php?app=event_space&event_id=<?php echo $event_id;?>" hidefocus="true"><?php echo $ef_langpackage->ef_activity;?></a></li>
		<li><a href="modules.php?app=event_member&event_id=<?php echo $event_id;?>" hidefocus="true"><?php echo $ef_langpackage->ef_member;?></a></li>
		<li class="active"><a href="modules.php?app=event_list_photo&event_id=<?php echo $event_id;?>" hidefocus="true"><?php echo $ef_langpackage->ef_photo;?></a></li>
    </ul>
  </div>
<?php if($photo_row){?>
	<div class="iframe_contentbox">
		<div class="photo_showbox">
			<div class="sub_box">
				<div class="photo_name"><span>《<?php echo filt_word($photo_row['photo_name']);?>》<?php echo $ef_langpackage->ef_come_from;?>：<?php echo $photo_row['user_name'];?></span></div>
				<div class="photo_uploadtime"><?php echo str_replace("{date}",$photo_row['add_time'],$a_langpackage->a_send_time);?></div>
				<div class="photo_view">
					<img id='<?php echo $t_event_photo;?>:<?php echo $photo_row["photo_id"];?>' style='display:none;max-width:470' onerror="parent.pic_error(this)" onmousemove='turnover(this);' />
					<img id='show_ajax' src='skin/<?php echo $skinUrl;?>/images/loading.gif' />
				</div>
				
				<?php if($photo_row['photo_information']!='' && $status < 3){?>
				<div id='def_photo_info'><?php echo filt_word($photo_row['photo_information']);?></div>
				<?php }?>
				
				<?php if($status>=3){?>
				<div class='photo_intro'>
					<input class="med-text" type='hidden' name='photo_id' id='photo_id' value=<?php echo $photo_id;?> />
					<div id='def_photo_info' onmouseover="this.style.backgroundColor='#ffffce';this.style.borderColor='#efcf7b';" onmouseout="this.style.backgroundColor='#fffbff';this.style.borderColor='#ececec';" onclick="change_state();"><?php echo filt_word($photo_inf);?></div>
					<div id='photo_info' style='display:none;text-align:center;'>
						<textarea class="med-textarea" cols='40' rows='2' name='information_value' id='information_value'></textarea><br />
						<input type='button' value='<?php echo $ef_langpackage->ef_b_con;?>' class='small-btn' onclick='change_photo()' />
						<input type='button' value='<?php echo $ef_langpackage->ef_b_del;?>' class='small-btn' onclick='chancel()' />
					</div>
				</div>
				<?php }?>
				
				<div class="photo_operate">
					<?php if($status>=3){?>
					<a href="javascript:void(0);" onclick="change_state();"><?php echo $a_langpackage->a_set_info;?></a>
					<?php }?>
					<a href="<?php echo $photo_row['photo_src'];?>" target="_blank"><?php echo $a_langpackage->a_see_pic;?></a>
					<a href="modules.php?app=event_list_photo&event_id=<?php echo $event_id;?>"><?php echo $a_langpackage->a_bak_list;?></a>
				</div>
				
			</div>
		</div>
	</div>
<?php }?>

<div id="face_list_menu" class="emBg" style="display:none;z-index:100;"></div>

<?php if($photo_row){?>
	<script type='text/javascript'>
		var img_obj=$('<?php echo $t_event_photo;?>:<?php echo $photo_row["photo_id"];?>');
		var ajax_obj=$('show_ajax');
		var show_img=new Image;
		show_img.src='<?php echo $photo_row["photo_src"];?>';
		var time_id=window.setTimeout("test_img_complete()",200);
		var show_width=<?php echo $img_info[0];?>>470?470:<?php echo $img_info[0];?>;
		function test_img_complete(){
			if(show_img.complete==true){
				img_obj.src='<?php echo $photo_row["photo_src"];?>';
				img_obj.width=show_width;
				img_obj.style.display='';
				ajax_obj.style.display='none';
				window.clearTimeout(time_id);
			}else{
				var time_id=window.setTimeout("test_img_complete()",200);
			}
		}
		function turnover(obj){
			var move_x=Get_mouse_pos(obj);
			if(move_x >= show_width/2){
				obj.style.cursor="URL(skin/<?php echo $skinUrl;?>/images/next.cur),auto";
				obj.title='<?php echo $a_langpackage->a_page_down;?>';
				obj.onclick=function(){location.href="modules.php?app=event_show_photo&event_id=<?php echo $event_id;?>&photo_id=<?php echo $photo_id;?>&prev_next=next&user_id=<?php echo $url_uid;?>"};
			}else{
				obj.style.cursor="URL(skin/<?php echo $skinUrl;?>/images/pre.cur),auto";
				obj.title='<?php echo $a_langpackage->a_page_up;?>';
				obj.onclick=function(){location.href="modules.php?app=event_show_photo&event_id=<?php echo $event_id;?>&photo_id=<?php echo $photo_id;?>&prev_next=prev&user_id=<?php echo $url_uid;?>"};
			}
		}
	</script>
<?php }?>

<div class="guide_info <?php echo $show_error;?>"><?php echo $a_langpackage->a_ine;?></div>
<div class="guide_info <?php echo $show_content;?>"><?php echo $a_langpackage->a_add_pvw;?></div>

</body>
</html>