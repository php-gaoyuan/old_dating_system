<?php
header("content-type:text/html;charset=utf-8");
require("foundation/asession.php");
require("configuration.php");
require("includes.php");

//引入公共方法
require("foundation/fcontent_format.php");
require("foundation/module_mood.php");
require("foundation/module_users.php");
require("foundation/fplugin.php");
require("foundation/fgrade.php");
require("api/base_support.php");

	//语言包引入
	$u_langpackage=new userslp;
	$pu_langpackage=new publiclp;
	$s_langpackage=new sharelp;
	$mn_langpackage=new menulp;
	$hi_langpackage=new hilp;
	$mo_langpackage=new moodlp;
	$pr_langpackage=new privacylp;
	$ah_langpackage=new arrayhomelp;
    $im_langpackage=new impressionlp;
	
	//变量获得
	$holder_id=intval(get_argg('h'));//主人id
	$user_id =get_sess_userid();
	$dress_name=short_check(get_argg('dress_name'));//装扮名称
	//echo $dress_name;
	//表声明区
	$t_mood=$tablePreStr."mood";
	$t_users=$tablePreStr."users";
	$t_online=$tablePreStr."online";

	//获取并重写url参数
	$urlParaStr=getReUrl();




	//取得主人信息
	$user_info=$holder_id ? api_proxy("user_self_by_uid","*",$holder_id):array();
	$holder_name=empty($user_info) ? '':$user_info['user_name'];
	$is_self=($holder_id==$user_id) ? 'Y':'N';

	if($user_info['user_group']=='base'||$user_info['user_group']=='1')
	{
		$mtype='<img width="19" height="17" src="skin/'.$skinUrl.'/images/xin/01.gif"/>&nbsp;';
	}
	else
	{
		$mtype='<img width="19" height="17" src="skin/'.$skinUrl.'/images/xin/0'.$user_info['user_group'].'.gif"/>&nbsp;';
	}

	//隐私显示控制
	$show_error=false;
	$show_ques=false;
	$is_visible=0;
	$show_info="";
	$dbo = new dbex;
	dbtarget('r',$dbServs);
	if($user_info){
	  //最后更新心情
		$last_mood_rs=get_last_mood($dbo,$t_mood,$holder_id);
		$last_mood_txt='';
		if($last_mood_rs['mood']){
			$last_mood_txt=get_face($last_mood_rs['mood']);
			$last_mood_time=format_datetime_short($last_mood_rs['add_time']);
		}else{
			$last_mood_txt=$mo_langpackage->mo_null_txt;
			$last_mood_time='';
		}
		//主人姓名
		set_session($holder_id.'_holder_name',$user_info['user_name']);
		$user_online=array();
		
		//登录状态
		$ol_state_ico="skin/$skinUrl/images/online.gif";
		$ol_state_label=$ah_langpackage->ah_current_online;
		$timer_txt='';
		$user_online=get_user_online_state($dbo,$t_online,$holder_id);
		if($is_self=='N'&&(empty($user_online)||$user_online['hidden']==1)){
		  $ol_state_ico="skin/$skinUrl/images/offline.gif";
		  $ol_state_label=$ah_langpackage->ah_offline;
		  $timer_txt='('.format_datetime_short($user_info['lastlogin_datetime']).')';
		}else if($is_self=='Y' && $user_online['hidden']==1){
			$ol_state_ico="skin/$skinUrl/images/hiddenline.gif";
			$ol_state_label=$ah_langpackage->ah_stealth;
		}

		$is_admin=get_sess_admin();
		if($is_admin==''&&$is_self=='N'){
			if($user_info['is_pass']==0){
				$show_error=true;$show_info=$pu_langpackage->pu_lock;
			}elseif($user_info['access_limit']==1 && $user_id==''){
				$show_error=true;$show_info=$pr_langpackage->pr_acc_false;
			}elseif($user_info['access_limit']==2 && !api_proxy("pals_self_isset",$holder_id)){
				$show_error=true;$show_info=$pr_langpackage->pr_acc_false;
			}elseif($user_info['access_limit']==3 && get_session($holder_id.'homeAccessPass')!='1'){
				$show_ques=true;
			}else{
				$is_visible=1;
			}
		}else{
			$is_visible=1;
		}
	}else{
		$show_error=true;$show_info=$pu_langpackage->pu_no_user;
	}

	if($user_id){
		$inc_header="uiparts/homeheader.php";
	}else{
		$inc_header="uiparts/guesttop.php";
	}




	$user_id =get_sess_userid();
	$sqlg = "select * from wy_users where user_id=$user_id";
	$sessuserinfo = $dbo->getRow($sqlg);


//圖片 Begin
	$response = array();
//photo_num = 当前相册的图片数量，is_pass=1 无密码
$sql = "SELECT album_id,album_name,album_info,photo_num,add_time FROM `wy_album` WHERE `user_id` = $holder_id";
$result = mysql_query($sql);




	$nCount = 0;

	while ($rows = mysql_fetch_assoc($result)) {
		$response[$nCount]['album_id'] = $rows['album_id'];
		$response[$nCount]['album_name'] = $rows['album_name'];
		$response[$nCount]['album_info'] = $rows['album_info'];
		$response[$nCount]['photo_num'] = $rows['photo_num'];
		$response[$nCount]['add_time'] = $rows['add_time'];
		$nCount++;
	}


//頁面頂部只需要4個圖片
	//需要新定義一個變量來處理頭部的圖片效果

	$topimg = array();  //數量=4


	$all = array();	//所有相册圖片集合
	$nCount = 0;
		foreach ($response as $key => $value) {
			$sql = "SELECT photo_id,photo_name,photo_information,add_time,photo_src,album_id FROM `wy_photo` WHERE `album_id` = '$value[album_id]'";
			$result = mysql_query($sql);

			$tmp = array();	//遍历其中的一个

			if($nCount < 4){
				while($rows = mysql_fetch_assoc($result)){
						$all[] = $rows;
				}
				$nCount++;
			}
			
		}


//圖片END


		//心情Begin



$sql = "select * from wy_mood where user_id=$holder_id";
$result = mysql_query($sql);


	$mood = array();
	while($rows = mysql_fetch_assoc($result)){
		$mood[] = $rows;
	}



		//心情End

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="Description" content="<?php echo $metaDesc;?>,<?php echo $holder_name;?>" />
<meta name="Keywords" content="<?php echo $metaKeys;?>,<?php echo $holder_name;?>" />
<meta name="author" content="<?php echo $holder_name;?>" />
<meta name="robots" content="all" />
<title><?php echo $holder_name;?>的个人主页-<?php echo $siteName;?></title>
<base href='<?php echo $siteDomain;?>' />
<?php $plugins=unserialize('a:0:{}');?>
<link rel="stylesheet" href="skin/<?php echo $skinUrl;?>/css/layout.css" />
<script type='text/javascript' src="skin/default/js/jy.js"></script>
<script type='text/javascript' src="servtools/imgfix.js"></script>
<script type='text/javascript' src="skin/default/js/jooyea.js"></script>
<SCRIPT type='text/javascript' src="servtools/ajax_client/ajax.js"></SCRIPT>
<script type="text/javascript" language="javascript" src="servtools/dialog/zDrag.js"></script>
<script type="text/javascript" language="javascript" src="servtools/dialog/zDialog.js"></script>
<script type="text/javascript" language="javascript" src="servtools/calendar.js"></script>



<link rel="stylesheet" href="skin/default/jooyea/css/xbase.css" />
<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>



<script type='text/javascript'>
function goLogin(){
	Dialog.confirm("<?php echo $pu_langpackage->pu_login;?>",function(){top.location="<?php echo $siteDomain;?><?php echo $indexFile;?>";});
}
//取得评论内容
	function get_mod_com(type_id,mod_id,start_num,end_num){
		if(frame_content.$("max_"+type_id+"_"+mod_id)){
			var max_num=parseInt(frame_content.$("max_"+type_id+"_"+mod_id).innerHTML);
			start_num=max_num;
		}
		var ajax_get_com=new Ajax();
		ajax_get_com.getInfo("modules.php","GET","app","app=restore&mod_id="+mod_id+"&type_id="+type_id+"&start_num="+start_num+"&end_num="+end_num,function(c){get_com_callback(c,type_id,mod_id);});
	}
	//回复评论
	function restore(user_name,type_id,mod_id,user_id){
		if(parseInt(<?php echo $user_id;?>)){
			if(frame_content.$("replycontent_"+type_id+"_"+mod_id)){
				frame_content.toggle2("reply_"+type_id+"_"+mod_id);
			}
			$('restore').value=user_id;
			frame_content.$('reply_'+type_id+'_'+mod_id+'_input').value='<?php echo $ah_langpackage->ah_reply;?>'+user_name+":";
		}else{
			goLogin();
		}
	}
	//回复评论
	function restore_com(holder_id,type_id,mod_id){
		var r_content=frame_content.$('reply_'+type_id+'_'+mod_id+'_input').value;
		var user_id='';
		if($('restore').value!=''){
			var user_id=$('restore').value;
		}
		//var is_hidden=frame_content.document.getElementById('hidden_'+type_id+'_'+mod_id).value;
		var is_hidden=0;
		if(trim(r_content)==''){
			Dialog.alert('<?php echo $pu_langpackage->pu_data_empty;?>');
		}else{
			var ajax_comment=new Ajax();
			ajax_comment.getInfo("do.php?act=restore_add&holder_id="+holder_id+"&type_id="+type_id+"&mod_id="+mod_id+"&is_hidden="+is_hidden+"&to_userid="+user_id,"post","app","CONTENT="+r_content,function(c){restore_com_callback(c,type_id,mod_id)});
		}
	}
	//删除评论
	function del_com(holder_id,type_id,parent_id,com_id,sendor_id){
		var ajax_del_com=new Ajax();
		ajax_del_com.getInfo("do.php","GET","app","act=restore_del&holder_id="+holder_id+"&type_id="+type_id+"&com_id="+com_id+"&sendor_id="+sendor_id+"&parent_id="+parent_id,function(c){del_com_callback(c,type_id,parent_id,com_id)});
	}
	//举报
	function report(type_id,user_id,mod_id){
		var diag = new Dialog();
		diag.Width = 300;
		diag.Height = 150;
		diag.Top="50%";
		diag.Left="50%";
		diag.Title = "<?php echo $pu_langpackage->pu_report;?>";
		diag.InnerHtml= '<div class="report_notice"><?php echo $pu_langpackage->pu_report_info;?><?php echo $pu_langpackage->pu_report_re;?><textarea id="reason"></textarea></div>';
		diag.OKEvent = function(){act_report(type_id, user_id, mod_id);diag.close();};
		diag.show();
	}
	//确认举报
	function act_report(type_id,user_id,mod_id){
		var reason_str=$("reason").value;
		if(trim(reason_str)){
			var ajax_act_report=new Ajax();
			ajax_act_report.getInfo("do.php?act=report_add&type="+type_id+"&uid="+user_id+"&mod_id="+mod_id,"post","app","reason="+reason_str,function(c){act_report_callback(c)});
		}else{
			Dialog.alert('<?php echo $pu_langpackage->pu_report_none;?>');
		}
	}
	//分享
	function show_share(share_type,share_content_id,s_title,s_link){
		var diag = new Dialog();
		diag.Width = 300;
		diag.Height = 180;
		diag.Top="50%";
		diag.Left="50%";
		diag.Title = "<?php echo $s_langpackage->s_share;?>";
		diag.InnerHtml= '<div class="share"><?php echo $s_langpackage->s_title;?><input maxlength="50" type="text" ' + (share_type<5 || share_type==8 ? 'disabled="disabled"' : '') + ' id="out_title" value="'+s_title+'" /><?php echo $ah_langpackage->ah_label;?>：<input type="text" id="tag" name="tag" value="" /><?php echo $s_langpackage->s_add_com;?><textarea id="share_com"></textarea></div>';
		diag.OKEvent = function(){act_share(share_type,share_content_id,s_title,s_link);diag.close();};
		diag.show();
	}
	//确认分享
	function act_share(share_type,share_content_id,title_data,re_link){
		if(share_type==5||share_type==6||share_type==7){
			var out_title=$("out_title").value;
			var title_data=trim(out_title);
		}
		var com_str=$("share_com").value;
		var tag=$("tag").value;
		var ajax_act_share=new Ajax();
		ajax_act_share.getInfo("do.php?act=share_action&s_type="+share_type+"&share_content_id="+share_content_id,"post","app","comment="+com_str+"&title_data="+title_data+"&re_link="+re_link+"&tag="+tag,function(c){act_share_callback(c,share_type)});
	}
	//主页装扮提示
	function dress_home(dress_name){
		Dialog.confirm('<?php echo $ah_langpackage->ah_enable_dress;?>',function(){top.location.href="do.php?act=user_dress_change&dress_name="+dress_name;},function(){top.location.href="main.php?app=user_dressup";});
	}
</script>

</head>
<body id="home">
<!--个人主页装扮!-->
<div class="banner">
  <!--banner图片-->
</div>

<!--head_start!-->
<?php require($inc_header);?>
<!--head_end!-->

<!--隐私权限-start!-->
<?php if($show_error==true){?>
<div class="error_box">
  <h2><?php echo $show_info;?></h2>
  <p><?php echo $ah_langpackage->ah_system_will;?><span id="skip">5</span><?php echo $ah_langpackage->ah_seconds_return;?></p>
  <p><a href="<?php echo $siteDomain;?><?php echo $indexFile;?>" title="<?php echo $ah_langpackage->ah_click_return_home;?>"><?php echo $ah_langpackage->ah_click_return_home;?>&gt;&gt;</a></p>
</div>
<?php }?>


<!--隐私权限-end!-->


<input type="hidden" id="restore" value="" />
<?php if($is_visible==1){?>
<!--home_start!-->
<div class="container">
<div class="home_start">
<div class="user_box">
	<div class="user_status">
        <div class="user_content">
            <h1><?php echo $user_info['user_name'];?></h1><span title="<?php echo count_level($user_info['integral']);?>"><?php echo grade($user_info['integral']);?></span>
            <span class="count">(<?php echo $ah_langpackage->ah_have;?><?php echo $user_info['guest_num'];?><?php echo $ah_langpackage->ah_had_seen;?>)</span>
            <span class="myword"><?php echo $last_mood_txt;?></span>
            <span class="time"><?php echo $last_mood_time;?></span><span class="time">|</span>
            <span class="time"><a href="javascript:;" onclick="frame_content.location.href='modules.php?app=mood_more&user_id=<?php echo $holder_id;?>'"><?php echo $ah_langpackage->ah_more_mood;?></a></span>
        </div>
	</div>
</div>
<div class="clear"></div>
<div id="home_tabs" class="tabs">
  <ul class="menu">
	  <li class="active"><a href="<?php echo $siteDomain;?>home2.0.php?h=<?php echo $holder_id;?>" ><?php echo $ah_langpackage->ah_personal_homepage;?></a></li>
<!-- 	  <li><a href="javascript:void(0);" onclick="frame_content.location.href='<?php echo $siteDomain;?>modules.php?app=user_info&user_id=<?php echo $holder_id;?>&single=1';return false;" hidefocus="true"><?php echo $ah_langpackage->ah_data;?></a></li> -->
	  <li><a href="javascript:void(0);" onclick="frame_content.location.href='<?php echo $siteDomain;?>modules.php?app=blog_list&user_id=<?php echo $holder_id;?>';return false;" hidefocus="true"><?php echo $ah_langpackage->ah_log;?></a></li>
	  <li><a href="javascript:void(0);" onclick="frame_content.location.href='<?php echo $siteDomain;?>modules.php?app=album&user_id=<?php echo $holder_id;?>';return false;" hidefocus="true"><?php echo $ah_langpackage->ah_album;?></a></li>
	  <li><a href="javascript:void(0);" onclick="frame_content.location.href='<?php echo $siteDomain;?>modules.php?app=share_list&user_id=<?php echo $holder_id;?>';return false;" hidefocus="true"><?php echo $ah_langpackage->ah_share;?></a></li>
    <li><a href="javascript:void(0);" onclick="frame_content.location.href='<?php echo $siteDomain;?>modules.php?app=mood_more&user_id=<?php echo $holder_id;?>';return false;" hidefocus="true"><?php echo $mn_langpackage->mn_mood;?></a></li>

  </ul>
</div>
<div class="wrapper" style="margin-top:0">
  <div class="main">


  <!--homeleft_start!-->
	<?php require("uiparts/homeleft.php");?>
	<!--homeleft_end!-->

	<div class="right">
	    <div class="right_l">
<!-- 

	    <iframe onload="this.height=frame_content.document.body.scrollHeight" id="frame_content" name="frame_content"  scrolling="no" frameborder="0" width="100%" allowTransparency="true"></iframe>



 -->








	      <!--最新照片-->
	      <?php if(!empty($all)) { ?>
	      <div class="new_photo">
	        <h3>Latest Photos</h3>
	        <ul>
	          <?php 


	          	foreach ($all as $key => $value) {
					if($key < 4){
								echo "<li>";
								echo "<img class=\"img\" onclick=\"show_photo('$value[photo_src]')\"
						   src=\"$value[photo_src]\" />";
								echo "</li>";
					}
	          	}
	          	

	          ?>


	        </ul>
	      </div>
	      <?php } ?>

	      <div class="moodlist">
	        <ul>


<!-- 心情 Begin -->

<?php 
	if(!empty($mood)){
		foreach($mood as $key => $value){
			$add_time = substr($value['add_time'], 0, 10);

			echo "<li>";
            echo "<div class=\"li_avatar\"><img src=\"$user_info[user_ico]\" /></div>
	            <div class=\"li_info\">
	              <div class=\"li_info_t\"><em><!-- × --></em><span><a>$value[user_name]</a> Published Mood: $add_time</span></div>
	              <div class=\"li_info_n\">
	                $value[mood] <br />
	               <!-- <p class=\"li_info_btn\">$add_time</p> -->
	              </div>
	            </div>";
			echo "</li>";
		}
	}

?>

<!-- 心情 End -->


<!-- 上傳圖片 Begin -->

<?php

	if(!empty($all)){

		foreach ($all as $key => $value) {
			$add_time = substr($value['add_time'], 0, 10);
			echo "<li>";

			echo "<div class=\"li_avatar\"><img src=\"$user_info[user_ico]\" /></div>
	            <div class=\"li_info\">
	              <div class=\"li_info_t\"><em><!-- × --></em><span><a>$user_info[user_name]</a> Uploaded Photo: $add_time</span></div>
	              <div class=\"li_info_n\">
	                <!-- $value[photo_src] <br /> -->
	                <img class=\"img\"  onclick=\"show_photo('$value[photo_src]')\" src=\"$value[photo_src]\" />
	                <!-- p class=\"li_info_btn\">$add_time</p> -->
	              </div>
	            </div>";
			echo "</li>";
		}
	}


?>


<!-- 上傳圖片 End -->



	        </ul>

	        <!-- <div class="fenye">暂无数据</div> -->
	      </div>

	    </div>

		
		
<?php if($sessuserinfo['user_group']==2 || $sessuserinfo['user_group'] == 3){ ?>
    
	    	<div class="com_user">
	    	  <div class="com_user_t"><span><?php echo $mn_langpackage->mn_visi;?></span></div>
	    	  <ul>

	    	  <?php

	    	  $guest_rs = api_proxy("guest_self_by_uid","*",$user_info['user_id'],10);

	    	  	foreach ($guest_rs as $key => $val) {
	    	  		# code...
	    	  	echo "<li>";
		    	  	echo "<a href=\"home2.0.php?h=$val[guest_user_id]\">";
		    	  	$size =  strlen($val['guest_user_ico']);
		    	  	$newtimestr = substr($val['add_time'], 0, 10);
		    	  	if($size == 0){
		    	  		echo "<img src=\"http://www.puivip.com/rootimg.php?src=http://www.puivip.com/skin/default/jooyea/images/d_ico_1.gif&h=82&w=82&z=1\" /></a>";
		    	  	}else{
		    	  		echo "<img src=\"http://www.puivip.com/rootimg.php?src=$val[guest_user_ico]&h=82&w=82&z=1\" /></a>";
		    	  	}
		    	  	echo "<span>";
			    	  	echo "<a href=\"home2.0.php?h=$val[guest_user_id]\">$val[guest_user_name]</a>";
			    	  	echo "<br />$newtimestr";
		    	  	echo "</span>";
	    	  	echo "</li>";
	    	  	}

	    	  ?>
	    	  </ul>
	    	</div>
			
			
			
		<? } else { ?>
 
            <div><a href='http://www.puivip.com/main.php?app=user_upgrade' target='_blank'><?php echo $u_langpackage->readmore; ?></a></div>

            <? } ?>	
			
			
			
			
			
			
			
			
			

	    </div>
	  </div>




  </div>

	

</div>


<script language=JavaScript src="servtools/ajax_client/auto_ajax.js"></script>
<?php }?>

<?php if($is_visible==0){?>
<script type='text/javascript'>
function countDown(secs,surl){
	if($('skip')){
	  $("skip").innerHTML=secs;
	  --secs > 0 ? setTimeout("countDown("+secs+",'"+surl+"')",1000):location.href=surl;
	}
}
countDown(5,'<?php echo $siteDomain;?><?php echo $indexFile;?>');
</script>
<?php }?>

<?php require("uiparts/footor.php");?>
</div>
</div><script language="JavaScript" src="im/im_forsns_js.php"></script>



































<div class="mask">
    <div class="show_photo">
        <div class="show_photo_t"><em onclick="hide_photo()">×</em><span>Picture Preview</span></div>
        <div class="show_photo_n"></div>
    </div>
</div>
<div class="mask2">
    <div class="show_photo2">
        <div class="show_photo_t2"><em onclick="hide_allphoto()">×</em><span>Picture Preview</span></div>
        <div class="show_photo_n2">
            <div class="allimg"></div>
        </div>
        <div class="left_bar" onclick="left_show()"></div>
        <div class="right_bar" onclick="right_show()"></div>
        <i></i>
    </div>
</div>
<style>
  .mask{width:100%;height:100%;background:url(/images/mask.png);position:fixed;top:0;left:0;display:none;}
  .show_photo{width:900px;height:500px;position:fixed;top:100px;left:0;right:0;margin-left:auto;margin-right:auto;background:#fff;}
  .show_photo_t{width:100%;line-height:25px;float:left;}
  .show_photo_t span{float:left;margin-left:10px;}
  .show_photo_t em{float:right;margin-right:10px;font-size:14px;cursor:pointer;border:#ddd 1px solid;width:20px;height:20px;text-align:center;line-height:20px;margin-top:5px;}
  .show_photo_n{width:880px;float:left;padding:10px;text-align: center}
  .show_photo_n img{max-width: 880px;max-height: 450px;}

  .mask2{width:100%;height:100%;background:url(/images/mask.png);position:fixed;top:0;left:0;display:none;}
  .show_photo2{width:900px;height:500px;position:fixed;top:100px;left:0;right:0;margin-left:auto;margin-right:auto;background:#fff;}
  .show_photo2 i{display:none;}
  .show_photo_t2{width:100%;line-height:25px;float:left;}
  .show_photo_t2 span{float:left;margin-left:10px;}
  .show_photo_t2 em{float:right;margin-right:10px;font-size:14px;cursor:pointer;border:#ddd 1px solid;width:20px;height:20px;text-align:center;line-height:20px;margin-top:5px;}
  .show_photo_n2{width:880px;height:450px;overflow:hidden;float:left;padding:10px;position: relative;}
  .allimg{width:auto;float:left;position: absolute;}
.img_show{width:880px;float:left;text-align: center;}
.img_show img{}


  .show_photo_n2 img{max-width: 880px;max-height: 450px;}
  .left_bar{width:80px;height:450px;position:absolute;left:0;bottom:0;background:url(/images/left.cur) no-repeat center center;cursor:pointer;}
  .right_bar{width:80px;height:450px;position:absolute;right:0;bottom:0;background:url(/images/right.cur) no-repeat center center;cursor:pointer;}

</style>
<script>
function show_photo(dz){
  $(".show_photo_n").html("<img src='"+dz+"' />");
  $(".mask").show();
}

function show_allphoto(id){
  var num=$(".moodlist .img").length
  width = num*880;
  $(".allimg").css("width",width+"px");
  var img = $(".moodlist .img").eq(id).attr('src');
  var html='';
  for(i=0;i<num;i++){
    html+="<div class='img_show'><img src='"+$(".moodlist .img").eq(i).attr('src')+"' /></div>";
  }

  $(".allimg").css("left",-(id*880)+"px");
  $(".allimg").html(html);
  $(".show_photo2 i").html(id);
  $(".mask2").show();
}

function left_show(){
  var i = parseInt($(".show_photo2 i").html());
  if(i=='0'){
    return false;
  }else{
    i=i-1;
    var img = $(".moodlist .img").eq(i).attr('src');
    $(".show_photo2 i").html(i);
    //$(".show_photo_n2").html("<img src='"+img+"' />" );
    left=-(i*880);
    $(".allimg").animate({'left': left+'px'}, 300)
  }

}

function right_show(){
  var num=$(".moodlist .img").length-1;
  var i = parseInt($(".show_photo2 i").html());
  if(i==num){
    return false;
  }else{
    i=i+1;
    $(".show_photo2 i").html(i);
    var img = $(".moodlist .img").eq(i).attr('src');
    left=-(i*880);
    $(".allimg").animate({'left': left+'px'}, 300)
  }

}
function hide_allphoto(){
  //$(".show_photo_n2").html("");
  $(".mask2").hide();
}

function hide_photo(){
  $(".show_photo_n").html("");
  $(".mask").hide();
}
</script>

</body>
</html>