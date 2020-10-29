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
?><?php
//add by root begin

  //引入语言包
$rem_langpackage=new remindlp;


//引入提醒模块公共函数
require("foundation/fdelay.php");
require("api/base_support.php");

//表定义区
$t_online=$tablePreStr."online";
$isset_data="";
$DELAY_ONLINE=4;
$is_action=delay($DELAY_ONLINE);
if($is_action){
  $dbo=new dbex;
  dbtarget('w',$dbServs);
  update_online_time($dbo,$t_online);
  rewrite_delay();
}
$remind_rs=api_proxy("message_get","remind");
//$remind_rs=$dbo->getRs("select * from wy_remind where user_id='$user_id' and is_focus=0");
//echo "<pre>";var_dump($remind_rs);exit;
if($langPackagePara=='zh')
{
  $remind_rs2=array();
  foreach($remind_rs as $r)
  {
    $mess=$r[4];
    $mess=str_replace("hello","个招呼",$mess);
    $r[4]=$mess;
    $r['content']=$mess;
    $remind_rs2[]=$r;
  }
  if(!empty($remind_rs2)){
    $remind_rs=$remind_rs2;
  }else{
    $remind_rs=array(array('count'=>'0','content'=>'暂时没有消息','link'=>'javascript:;'));
  }
}
else //if($langPackagePara=='en')
{
  $remind_rs2=array();
  foreach($remind_rs as $r)
  {
    $mess=$r[4];
    $mess=str_replace("个招呼"," hello",$mess);
    $r[4]=$mess;
    $r['content']=$mess;
    $remind_rs2[]=$r;
  }
  if(!empty($remind_rs2)){
    $remind_rs=$remind_rs2;
  }else{
    $remind_rs=array(array('count'=>'0','content'=>'There is no news!','link'=>'javascript:;'));
  }
}

if(empty($remind_rs)){
  $isset_data="content_none";
}

//add by root end


  //引入语言包
  $mn_langpackage=new menulp;
  $u_langpackage=new userslp;
  $ah_langpackage=new arrayhomelp;
  
  $send_msgscrip='modules.php?app=msg_creator&2id='.$holder_id.'&nw=2';
  $add_friend="javascript:mypalsAddInit($holder_id)";
  $leave_word='modules.php?app=msgboard_more&user_id='.$holder_id;
  $send_hi="hi_action($holder_id)";
  $send_report="report_action(10,$holder_id,$holder_id);";
    $impression='modules.php?app=impression&user_id='.$holder_id;
  if(!isset($user_id)){
      $send_msgscrip="javascript:parent.goLogin();";
      $add_friend='javascript:parent.goLogin()';
      $leave_word="javascript:parent.goLogin();";
      $send_hi='javascript:parent.goLogin()';
      $send_report='javascript:parent.goLogin()';
      set_session('pre_login_url',$_SERVER["REQUEST_URI"]);
  } $uu=$dbo->getRow("select is_txrz,user_group,integral from wy_users where user_id='$holder_id'");    //未读邮件数量$email_count=$dbo->getRs("select readed from wy_msg_inbox where user_id='$user_id' and readed=0");$email_num=count($email_count);



$user_id =get_sess_userid();
$sqlg = "select * from wy_users where user_id=$user_id";
$sessuserinfo = $dbo->getRow($sqlg);


$user_id = $holder_id;
$sqlg = "select count(*) from wy_album where user_id=$user_id";
$albumcount = $dbo -> getRow($sqlg);


$sqlg =  "select count(*) from wy_blog where user_id=$user_id";
$blogcount = $dbo -> getRow($sqlg);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="Description" content="lovelove.com－亞洲最大的跨語言愛情在綫互動交友公寓網站,lovelove makes through games, shares interests and hobbies, friends advice, you browse the personal data and more way to get to know and make new friends. It is an international dating service,xiaosu" />
<meta name="Keywords" content="single girls,Single dating,Dating site, free personals,lovelove國際交友,亞洲交友,海外交友,xiaosu" />
<meta name="author" content="xiaosu" />
<meta name="robots" content="all" />
<title>xiaosu的个人主页-lovelove亚洲国际交友中心网站－You match with single girls by dating_单身男女的爱情公寓</title>
<base href='http://www.pauzzz.com/' />
<link rel="stylesheet" href="skin/default/jooyea/css/layout.css" />
<script type='text/javascript' src="skin/default/js/jy.js"></script>
<script type='text/javascript' src="servtools/imgfix.js"></script>
<script type='text/javascript' src="skin/default/js/jooyea.js"></script>
<SCRIPT type='text/javascript' src="servtools/ajax_client/ajax.js"></SCRIPT>
<script type="text/javascript" language="javascript" src="servtools/dialog/zDrag.js"></script>
<script type="text/javascript" language="javascript" src="servtools/dialog/zDialog.js"></script>
<script type="text/javascript" language="javascript" src="servtools/calendar.js"></script>

<!-- -->
<link rel="stylesheet" href="skin/default/jooyea/css/xbase.css" />
<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>



<!-- -->

<script type='text/javascript'>
function goLogin(){
	Dialog.confirm("After logging in to perform operations, login now？",function(){top.location="http://www.pauzzz.comn/index.php";});
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
		if(parseInt(33601)){
			if(frame_content.$("replycontent_"+type_id+"_"+mod_id)){
				frame_content.toggle2("reply_"+type_id+"_"+mod_id);
			}
			$('restore').value=user_id;
			frame_content.$('reply_'+type_id+'_'+mod_id+'_input').value='Reply'+user_name+":";
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
			Dialog.alert('Comments can not be empty');
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
		diag.Title = "Violation to report";
		diag.InnerHtml= '<div class="report_notice">Thank you for your management web site with us, we will quickly for processingPlease fill in the report the reasons：<textarea id="reason"></textarea></div>';
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
			Dialog.alert('Please fill out the report right reasons！');
		}
	}
	//分享
	function show_share(share_type,share_content_id,s_title,s_link){
		var diag = new Dialog();
		diag.Width = 300;
		diag.Height = 180;
		diag.Top="50%";
		diag.Left="50%";
		diag.Title = "Share";
		diag.InnerHtml= '<div class="share">Title：<input maxlength="50" type="text" ' + (share_type<5 || share_type==8 ? 'disabled="disabled"' : '') + ' id="out_title" value="'+s_title+'" />Tag：<input type="text" id="tag" name="tag" value="" />Add a comment：<textarea id="share_com"></textarea></div>';
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
		Dialog.confirm('Enable this dress up？',function(){top.location.href="do.php?act=user_dress_change&dress_name="+dress_name;},function(){top.location.href="main.php?app=user_dressup";});
	}
</script>

</head>







































<script type='text/javascript' language="javascript">
function goLogin(){
  Dialog.confirm("<?php echo $pu_langpackage->pu_login;?>",function(){top.location="<?php echo $indexFile;?>";});
}

function mypalsAddInit(other_id)
{
    var mypals_add=new Ajax();
    mypals_add.getInfo("do.php","GET","app","act=add_mypals&other_id="+other_id,function(c){if(c=="success"){Dialog.alert("<?php echo $ah_langpackage->ah_friends_add_suc;?>");}else{Dialog.alert(c);}});
}
function hi_action_int(){
  <?php echo $send_hi;?>;
}

function report_action_int(){
  <?php echo $send_report;?>
}

function report_action(type_id,user_id,mod_id){
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

function hi_action(uid){
  var diag = new Dialog();
  diag.Width = 330;
  diag.Height = 150;
  diag.Top="50%";
  diag.Left="50%";
  diag.Title = "<?php echo $u_langpackage->u_choose_type;?>";
  diag.InnerHtml= '<?php echo hi_window();?>';
  diag.OKEvent = function(){send_hi(uid);diag.close();};
  diag.show();
}

function send_hi_callback(content){
  if(content=="success"){
    Dialog.alert("<?php echo $hi_langpackage->hi_success;?>");
  }else{
    Dialog.alert(content);
  }
}

function send_hi(uid){
  var hi_type=document.getElementsByName("hi_type");
  for(def=0;def<hi_type.length;def++){
    if(hi_type[def].checked==true){
      var hi_t=hi_type[def].value;
    }
  }
  var get_album=new Ajax();
  get_album.getInfo("do.php","get","app","act=user_add_hi&to_userid="+uid+"&hi_t="+hi_t,function(c){send_hi_callback(c);});
}
</script>













<body>
<div class="head_w" id="head_navs" style="height:50px;background:#b20000;position:fixed;top:0;z-index:1000;-webkit-box-shadow: 0px 1px 3px;-moz-box-shadow: 0px 1px 3px;box-shadow: 0px 1px 3px;">
    <div class="search" id="main_search">
      <div class="snslogo">
        <a href="main.php"><img src="skin/default/jooyea/images/snslogo.png"/></a>
        <div class="top_msg" id="top_msg_hv" onmouseout="sideMenuShow(false);" onmouseover="sideMenuShow(true);"><span class="msg_1"><span id="top_msg_num">8</span></span></div>
        <div class="msg_iframe">
          <iframe id="remind" name="remind" src="modules.php?app=remind" scrolling="no" frameborder="0" allowTransparency="true" onmouseout="sideMenuShow(false);document.getElementById('top_msg_hv').style.backgroundColor=''" onmouseover="sideMenuShow(true);document.getElementById('top_msg_hv').style.backgroundColor='#fff'" style="display:none;width:160px;"></iframe>
        </div>
      </div>
      <!--<div class="schbox main_schbox">
        <form class="search_box" action="main.php" onsubmit="clear_def(this,'Enter the name...');">
          <input id="searchtop_input" maxlength='20' class="inpt" type="text" name='memName' value="Enter the name..." onblur="inputTxt(this,'set');" onfocus="inputTxt(this,'clean');" />
          <input class="btn" type="submit" value="" />
          <input type='hidden' name='app' value='mypals_search_list' />
        </form>
      </div>-->
      <div class="main_top_nav">
        <ul>
          <li><a href="main.php?app=user_pay">Recharge</a></li>
          <li><a href="main.php">Home</a></li>
          <li><a href="home2.0.php?h=33601" target="_blank">My home page</a></li>
          <!-- <li><a href="main.php?app=mypals_search_list&online=1" hidefocus="true" >看谁在线</a></li> -->
          <li><a href="javascript:void(0);" onclick="location.href='main.php?app=mypals';return false;" hidefocus="true">Circle of friends</a></li>
          <li><a href="main.php?app=mypals_search">Search</a></li>
          <li id="li_sitting" onmouseout="setMenuShow(false);" onclick="setMenuShow(true);" onmouseover="setMenuShow(true);"><a><img src="skin/default/jooyea/images/setting.png"/><!--Set up--></a></li>
          <li><a href="main.php?app=user_dressup" target="_top" hidefocus="true"><img src="skin/default/jooyea/images/skint.png"/><!--Skin--></a></li>
          
        </ul>
        <div id="set_menu_bridge" style="display:none;" onmouseover="setMenuShow(true);" onmouseout="setMenuShow(false);">
                    <ul id="set_menu" class="set_menu" style="display:none;">
                        <li class="user_info"><a href="modules.php?app=user_info" target="frame_content">User Information</a></li>
                        <li class="user_ico"><a href="modules.php?app=user_ico" target="frame_content" hidefocus="true">Picture Settings</a></li>
                        <li class="user_pw_change"><a href="modules.php?app=user_pw_change" target="frame_content">Change Password</a></li>
                        <li class="user_dressup"><a href="modules.php?app=user_dressup" target="frame_content">Home Dress</a></li>
                        <!-- <li class="user_affair"><a href="modules.php?app=user_affair" target="frame_content" hidefocus="true">News Feed settings</a></li> -->
                        <li class="user_privacy"><a href="modules.php?app=privacy" target="frame_content">Privacy Settings</a></li>
                        <li class="user_privacy"><a href="do.php?act=logout">Quit</a></li>
                    </ul>
              </div>
      </div>
      <!-- <a href="modules.php?app=mypals_search" target="frame_content">Advanced search</a> -->
    </div>
    
</div>
<div class="banner">
  <!--banner图片-->
</div>

<div class="top">
  <div class="username">
    <!--预览
    <em><input type="submit" value="保存" /> <input type="submit" value="退出" /></em>-->
    <span><a href=""><?php echo $user_info['user_name'];?></a> Online</span>
  </div>
  <div class="index_bar">
  	<span class="index_bar_c"><a href="/u/index.php/class/main/id/2062">MyHome</a></span>
  	<span><a href="/u/index.php/class/album/id/2062">Album</a></span>
  	<span><a href="/u/index.php/class/article/id/2062">Blogs</a></span>
  	<span><a href="/u/index.php/class/mood/id/2062">Sharing</a></span>
  	<span><a href="/u/index.php/class/skin/id/2062">Skin</a></span>  </div>
</div>
<div class="main">
  <div class="left">
  	<div class="avatar">
  	  <img src="<?php if($user_info['user_ico']){ echo str_replace("_small","",$user_info['user_ico']);}else{echo "/skin/default/jooyea/images/d_ico_".$user_info['user_sex'].".gif";}?>" title="liner" />
  	</div>
  	<div class="rz_zp">
  		<span class="rz_zp_c"><?php echo $blogcount[0]; ?><br /><?php echo $ah_langpackage->ah_log;?></span>
      <span><?php echo $albumcount[0];?><br /><?php echo $ah_langpackage->ah_album;?></span>
      <span><?php echo $uu['integral'];?><br /><?php echo $u_langpackage->u_integral;?></span>
  	</div>
    <div class="grade">
      <span><?php echo $pu_langpackage->pu_levl;?>:<?php echo grade($user_info['integral']);?></span>
      <span><?php echo $u_langpackage->huizhang;?>徽章:<?php if($uu['user_group']==2){echo '<img src="/skin/default/jooyea/images/xin/gaoji.png" />';} if($uu['user_group']==3){echo '<img src="/skin/default/jooyea/images/xin/vip.gif" />';}?>    <?php if($uinfo['is_txrz']==1){echo '<i class="txrz_home" title="'.$u_langpackage->touxiangrenzheng.'"></i>';}?></span>
    </div>
    <div class="userinfo">
      <span>View Profile</span>
    </div>

    <div class="userdesc">
      <span><?php echo $uinfo['country']?$uinfo['country']:$u_langpackage->u_set;?></span>
      <span><?php echo $ah_langpackage->ah_birthday;?>:<?php echo $user_info["birth_year"]&&$user_info["birth_month"]&&$user_info["birth_day"]?$user_info["birth_year"].$u_langpackage->u_year.$user_info["birth_month"].$u_langpackage->u_month.$user_info["birth_day"].$u_langpackage->u_day:$u_langpackage->u_set;?></span>
    </div>
  </div>  <div class="right">
    <div class="right_l">
      <!--最新照片-->
      <div class="new_photo">
        <h3>Latest Photos</h3>
        <ul>
          <li>
            <img class="img" onclick="show_photo('/uploads/liner/14230090367439.jpg')" src="/uploads/liner/14230090367439.jpg" />
            <img src="" class="block" />
          </li>
          <li>
            <img class="img" onclick="show_photo('/uploads/liner/14230089943475.jpg')" src="/uploads/liner/14230089943475.jpg" />
            <img src="" class="block" />
          </li>
          <li>
            <img class="img" onclick="show_photo('/uploads/liner/14230089758386.jpg')" src="/uploads/liner/14230089758386.jpg" />
            <img src="" class="block" />
          </li>
          <li>
            <img class="img" onclick="show_photo('/uploads/liner/14230089539336.jpg')" src="/uploads/liner/14230089539336.jpg" />
            <img src="" class="block" />
          </li>
        </ul>
      </div>
      <!--发表说说-->
      <div class="mood">
        <textarea name="" ></textarea>
      </div>
      <!--说说列表-->
      <div class="moodlist">
        <ul>
          <li>
            <div class="li_avatar"><img src="http://www.pauzzz.com/rootimg.php?src=http://www.pauzzz.com/uploadfiles/avatar/20141105/1415171817194_162.jpg&h=200&w=200&z=1" /></div>
            <div class="li_info">
              <div class="li_info_t"><em><!-- × --></em><span><a href="#">liner</a> Uploaded Photo: 3 Day Ago</span></div>
              <div class="li_info_n">
                $@64{{5{}W9H{L{3@JY$323.jpg <br />
                <img class="img"  onclick="show_photo('/uploads/liner/14230089943475.jpg')" src="/uploads/liner/14230089943475.jpg" />
                <p class="li_info_btn">2015/02/04 08:16</p>
              </div>
            </div>
          </li>
          <li>
            <div class="li_avatar"><img src="/avatar/liner_200_200.jpg" /></div>
            <div class="li_info">
              <div class="li_info_t"><em><!-- × --></em><span><a href="#">liner</a> Uploaded Photo: 3 Day Ago</span></div>
              <div class="li_info_n">
                xin.jpg <br />
                <img class="img"  onclick="show_photo('/uploads/liner/14230089758386.jpg')" src="/uploads/liner/14230089758386.jpg" />
                <p class="li_info_btn">2015/02/04 08:16</p>
              </div>
            </div>
          </li>
          <li>
            <div class="li_avatar"><img src="/avatar/liner_200_200.jpg" /></div>
            <div class="li_info">
              <div class="li_info_t"><em><!-- × --></em><span><a href="#">liner</a> Uploaded Photo: 3 Day Ago</span></div>
              <div class="li_info_n">
                %3G]CUX@JAQHL3Q$PI0PG_N.jpg <br />
                <img class="img"  onclick="show_photo('/uploads/liner/14230089539336.jpg')" src="/uploads/liner/14230089539336.jpg" />
                <p class="li_info_btn">2015/02/04 08:15</p>
              </div>
            </div>
          </li>
 <!--
          <li>
            <div class="li_avatar"><img src="/avatar/woqu_200_200.jpg" /></div>
            <div class="li_info">
              <div class="li_info_t"><em>×</em><span><a href="#">woqu</a> 上传了 照片:2014-05-05</span></div>
              <div class="li_info_n">
                sfsdfsdbr <br />
                <img class="img" src="/uploads/20140902/14096503052210.jpg" />
                <p class="li_info_btn">2014/25/25</p>
              </div>
            </div>
          </li>
        -->
        </ul>
        <!-- <div class="fenye">暂无数据</div> -->
      </div>

    </div>
    <div class="right_r">
      <h4>Recent Visitors</h4>
      <ul>
        <li><a href="/u/index.php/id/2037"><img src="/avatar/nophoto.gif" title="root"></a><span><a href="/u/index.php/id/2037">root</a><br></span></li>
        <li><a href="/u/index.php/id/2129"><img src="/avatar/nophoto.gif" title="boris"></a><span><a href="/u/index.php/id/2129">boris</a><br>17 Hours Ago</span></li>
        <li><a href="/u/index.php/id/2128"><img src="/avatar/nophoto.gif" title="Tbs210"></a><span><a href="/u/index.php/id/2128">Tbs210</a><br>18 Hours Ago</span></li>
        <li><a href="/u/index.php/id/2124"><img src="/avatar/Pinker_200_200.jpg" title="Pinker"></a><span><a href="/u/index.php/id/2124">Pinker</a><br>20 Hours Ago</span></li>
        <li><a href="/u/index.php/id/953"><img src="/avatar/nophoto.gif" title="Coeur"></a><span><a href="/u/index.php/id/953">Coeur</a><br>22 Hours Ago</span></li>
      </ul>
    </div>
  </div></div>
<div class="foot">
 <a class="ft" href="/?lang=en-us">English</a>|<a class="ft" href="/?lang=zh-cn">简体中文</a> |<a class="ft" href="/?lang=zh-tw">繁體中文</a>|<a class="ft" href="/?lang=ko-kr">한국어</a>|<a class="ft" href="/?lang=ru-ru">Pусский</a> |<a class="ft" href="/?lang=de-de">Deutsch</a>|<a class="ft" href="/?lang=es-es">Español</a>|<a class="ft" href="/?lang=ja-jp">日本語</a> <br />
 Copyright 2011-2015 zestlove.com <a href="/about.php" target="_blank">About Us</a>  <a href="/safety.php" target="_blank">Privacy </a> <a href="/terms.php" target="_blank">Terms </a> <a href="/help.php" target="_blank">Help Center </a>

</div>

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
<script language="JavaScript" src="im/im_forsns_js.php"></script>
</body>




















</html>