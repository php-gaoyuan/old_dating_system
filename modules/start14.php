<?php

/*

 * 注意：此文件由tpl_engine编译型模板引擎编译生成。

 * 如果您的模板要进行修改，请修改 templates/default/modules/start14.html

 * 如果您的模型要进行修改，请修改 models/modules/start14.php

 *

 * 修改完成之后需要您进入后台重新编译，才会重新生成。

 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。

 * 如果您正式运行此程序时，请切换到service模式运行！

 *

 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。

 */

?><?php

/*

 * 此段代码由debug模式下生成运行，请勿改动！

 * 如果debug模式下出错不能再次自动编译时，请进入后台手动编译！

 */

/* debug模式运行生成代码 开始 */

if(!function_exists("tpl_engine")) {

	require("foundation/ftpl_compile.php");

}

if(filemtime("templates/default/modules/start14.html") > filemtime(__file__) || (file_exists("models/modules/start14.php") && filemtime("models/modules/start14.php") > filemtime(__file__)) ) {

	tpl_engine("default","modules/start14.html",1);

	include(__file__);

}else {

/* debug模式运行生成代码 结束 */

?><?php

//引入心情模块公共方法

	require("foundation/module_mood.php");

	require("foundation/module_users.php");

	require("foundation/fgrade.php");

	require("foundation/fdnurl_aget.php");

	require("api/base_support.php");

	require("foundation/auser_mustlogin.php");

	

	require("foundation/auser_mustlogin.php");

	require("foundation/fpages_bar.php");

	require("servtools/menu_pop/trans_pri.php");

	require("foundation/module_mypals.php");



//引入语言包

	$mo_langpackage=new moodlp;

	$u_langpackage=new userslp;

	$rf_langpackage=new recaffairlp;

	$ah_langpackage=new arrayhomelp;



	$a_langpackage=new albumlp;

	$rond=get_argg('rond');

	

	$user_id=get_sess_userid();

	$mypals=get_sess_mypals();



	//数据表定义区

	$t_mood=$tablePreStr."mood";



	$dbo=new dbex;

	//读写分离定义方法

	dbtarget('r',$dbServs);



	//获得最新的心情

	$last_mood_rs=get_last_mood($dbo,$t_mood,$user_id);

	$last_mood_txt='';

	if(isset($last_mood_rs['mood'])){

		$last_mood_txt=sub_str($last_mood_rs['mood'],35).' [<a href="modules2.0.php?app=mood_more">'.$mo_langpackage->mo_more_label.'</a>]';

	}else{

		$last_mood_txt=$mo_langpackage->mo_null_txt;

	}

	

	$user_info=api_proxy("user_self_by_uid","guest_num,integral,onlinetimecount",$user_id);

	$remind_rs=api_proxy("message_get","remind",1,5);//取得空间提醒

	$remind_count=api_proxy("message_get_remind_count");//取得空间提醒数量





	//变量取得

	$album_id=intval(get_argg('album_id'));



	//数据表定义区

	$t_album = $tablePreStr."album";

	

	$send_join_js="parent.mypals_add({uid});";

	$send_hi="parent.hi_action";



	$dbo=new dbex;

	dbtarget('r',$dbServs);



	$page_num=intval(get_argg('page'));

	$page_total='';

	$album_rs=array();

	$album_rs = api_proxy("album_self_by_uid2","*",$pals_id_str);



	$isNull=0;//不为空则设置为零

	$a_friend="";

	$t_fri="content_none";

	if(empty($album_rs)){

		$isNull=1;//判断结果集是否为空

		$a_friend="content_none";

		$t_fri="";

	}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title></title>

<base href='<?php echo $siteDomain;?>' />

<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css" />

<script language=JavaScript src="skin/default/js/jooyea.js"></script>

<SCRIPT language=JavaScript src="servtools/ajax_client/ajax.js"></SCRIPT>

<script type='text/javascript'>

	var rond='<?php echo $rond;?>';

	function set_state_view(set_ol_hidden){

		var ol_state_ico=$("ol_ioc_gif");

		var ol_state_label=$("ol_label_txt");

		var ol_state_reset=$("set_state");

		if(set_ol_hidden==1){

			ol_state_ico.src='skin/<?php echo $skinUrl;?>/images/hiddenline.gif';

			ol_state_label.innerHTML='<?php echo $u_langpackage->u_hidden;?>';

			ol_state_reset.innerHTML='<a href="javascript:set_ol_state(0);"><?php echo $u_langpackage->u_set_onl;?></a>';

		}else if(set_ol_hidden==0){

			ol_state_ico.src='skin/<?php echo $skinUrl;?>/images/online.gif';

			ol_state_label.innerHTML='<?php echo $u_langpackage->u_onl;?>';

			ol_state_reset.innerHTML='<a href="javascript:set_ol_state(1);"><?php echo $u_langpackage->u_set_hidden;?></a>';

		}

	}

	function set_ol_state(set_ol_hidden){

		var ol_state=new Ajax();//实例化Ajax

		ol_state.getInfo("do.php","GET","app","act=user_ol_reset&is_hidden="+set_ol_hidden,function(c){set_state_view(set_ol_hidden);});

	}



	function submit_new_mood(){

		var last_mood_div=$("the_last_mood");

		var mood_text=trim($("mood_txt").value);

		if(mood_text==''){

			parent.Dialog.alert("<?php echo $mo_langpackage->mo_add_err;?>");

		}else{

			last_mood_div.innerHTML='<?php echo $u_langpackage->u_data_post;?>';

			var postStr="mood="+$("mood_txt").value;

			var new_mood=new Ajax();//实例化Ajax

			new_mood.getInfo("do.php?act=mood_add&ajax=1","post","app","mood="+$("mood_txt").value,function(c){last_mood_div.innerHTML=c;$("mood_txt").value="";});

		}

	}



function clear_remind(remind_id){

	if(parseInt($("remind_count").innerHTML)==1){

		$("remind_main").style.display='none';

	}

	$("remind_count").innerHTML=parseInt($("remind_count").innerHTML)-1;

	var ajax_remind=new Ajax();

	ajax_remind.getInfo("do.php","GET","app","act=message_del&id="+remind_id,function(c){$("remind_list").innerHTML=c;});

}



function changeStyle(obj){

	var tagList = obj.parentNode;

	var tagOptions = tagList.getElementsByTagName("li");

	for(i=0;i<tagOptions.length;i++){

		if(tagOptions[i].className.indexOf('active')>=0){

			tagOptions[i].className = '';

		}

	}

	obj.className = 'active';

}

parent.showDiv();

</script>

</head>

<body id="main_iframe">

<input type='hidden' id='affair_type' value=0 />

<input type='hidden' id='affair_start_num' value=0 />

<div class="mypanel">

    <div class="myphoto">

		<a hidefocus="true" target="frame_content" href="modules2.0.php?app=user_ico"><img src="<?php echo get_sess_userico();?>" /></a>

		<ul>

			<li style="font-size: 12px;padding-left: 6px;height:20px;line-height:20px;text-align:left;">

				<a hidefocus="true" target="frame_content" href="modules2.0.php?app=user_info"><?php echo $u_langpackage->u_info;?></a>

			</li>

			<li style="font-size: 12px;padding-left: 6px;height:20px;line-height:20px;text-align:left;">

				<a hidefocus="true" target="frame_content" href="modules2.0.php?app=user_ico"><?php echo $u_langpackage->u_icon;?></a>

			</li>

		</ul>

	</div>

    <div class="myinfo">

        <span class="left">

            <a class="strong" href="<?php echo get_uhome_url(get_sess_userid());?>" target="_blank"><?php echo filt_word(get_sess_username());?></a>

            <span id='on_line_state' class="mystatus" onmouseover='show_obj("set_state");' onmouseout='hidden_obj("set_state");'>

                <img id="ol_ioc_gif" src='skin/<?php echo $skinUrl;?>/images/online.gif'>

                <span id='ol_label_txt' style='color:#838383'></span>

                <span id='set_state' class='mystatus' onmouseover='show_obj("set_state");' onmouseout='hidden_obj("set_state");' style="display:none;"></span>

            </span>

        </span>

        <span class="stats"> <?php echo str_replace(array("{visitor_num}","{integral}","{uid}"),array($user_info['guest_num'],$user_info['integral'],$user_id),$u_langpackage->u_ustate);?>

            <span title="<?php echo count_level($user_info['onlinetimecount']);?>"><?php echo grade($user_info['onlinetimecount']);?></span>

        </span>

    </div>

    <div class="sendbox">

      <textarea type="text" name="mood_txt" maxlength="140" onkeyup="return isMaxLen(this)" onclick="showFace(this,'face_list_menu','mood_txt');" onblur="show('face_list_menu',200)" id="mood_txt" ></textarea>

      <input type="submit" name="button" id="button" style="font-weight:bold;color:#999;" value="<?php echo $u_langpackage->u_putout;?>" onclick="submit_new_mood();" />

      <span id="the_last_mood" class="newmood"><?php echo filt_word($last_mood_txt);?></span>

    </div>

</div>

<!--空间提醒!-->

<?php if($remind_rs){?>

<div class="remind_box" id="remind_main">

	<div class="remind_title">

		<a href="modules2.0.php?app=remind_message" class="more"><?php echo $rf_langpackage->rf_more;?></a>

		<?php echo $rf_langpackage->rf_space;?>(<span id='remind_count'><?php echo $remind_count[0];?></span>)

	</div>

	<ul class="remind_list" id="remind_list">

		<?php foreach($remind_rs as $rs){?>

			<li id='remind_<?php echo $rs['id'];?>'>

				<div class="photo"><a href="home2.0.php?h=<?php echo $rs['from_uid'];?>" target="_blank"><img src="<?php echo $rs['from_uico'];?>" width="20px" height="20px" alt="" target="_blank" /></a></div>

				<div class="remind_content">

					<a href="home2.0.php?h=<?php echo $rs['from_uid'];?>" target="_blank"><?php echo $rs['from_uname'];?></a>

					<?php echo str_replace(array("{link}","{js}"),array($rs['link'],"clear_remind(".$rs['id'].")"),filt_word($rs['content']));?>

					<?php echo $rs['count']>=2 ? "(".$rs['count'].$ah_langpackage->ah_times.")":'';?>

				</div>

				<div class="remind_del"><a href="javascript:clear_remind(<?php echo $rs['id'];?>)"></a></div>

			</li>

		<?php }?>

	</ul>

</div>

<div class="clear"></div>

<?php }?>



<!--空间提醒!-->

<div class="tabs" style="padding-left:8px;">

    <ul class="menu">

		<li class="active"><a href="javascript:;" hidefocus="true"><?php echo $rf_langpackage->rf_hylb;?></a></li>

        <!--<li onclick="list_recent_affair(<?php echo $user_id;?>,0);changeStyle(this);" class="active"><a href="javascript:;" hidefocus="true"><?php echo $rf_langpackage->rf_affair;?></a></li>

        <li onclick="list_recent_affair(<?php echo $user_id;?>,1);changeStyle(this);"><a href="javascript:;" hidefocus="true"><?php echo $rf_langpackage->rf_state;?></a></li>

        <li onclick="list_recent_affair(<?php echo $user_id;?>,2);changeStyle(this);"><a href="javascript:;" hidefocus="true"><?php echo $rf_langpackage->rf_album;?></a></li>

        <li onclick="list_recent_affair(<?php echo $user_id;?>,3);changeStyle(this);"><a href="javascript:;" hidefocus="true"><?php echo $rf_langpackage->rf_blog;?></a></li>

        <li onclick="list_recent_affair(<?php echo $user_id;?>,4);changeStyle(this);"><a href="javascript:;" hidefocus="true"><?php echo $rf_langpackage->rf_share;?></a></li>-->

    </ul>

</div>

<div class="album_holder">

	<?php foreach($album_rs as $val){?>

	  <?php $is_pri=check_pri($val['user_id'],$val['privacy']);?>

			<dl class="list_album" onmouseover="this.className += ' list_album_active';" onmouseout="this.className='list_album';" style="height:140px;width:20%;padding-left:130px;" >

				<dt style="margin-left:-135px;width:130px;height:130px;background-image:url('');"><a target="_blank" href="<?php echo $is_pri ? "home2.0.php?h=".$val['user_id']."&app=photo_list&album_id=".$val['album_id']."&user_id=".$val['user_id']:"javascript:void(0)";?>' style="width:110px;height:110px;"><img src=<?php echo $is_pri ? $val['album_skin'] : "skin/$skinUrl/images/errorpage.gif";?> onerror="parent.pic_error(this)" class='user_ico' style="width:110px;height:110px;" ></a></dt>

				<dd><strong><a target="_blank" href="<?php echo $is_pri ? "home2.0.php?h=".$val['user_id']."&app=photo_list&album_id=".$val['album_id']."&user_id=".$val['user_id']:"javascript:void(0)";?>"><?php echo filt_word($val['album_name']);?></a></strong></dd>

				<dd><?php echo $val['user_name'];?><?php echo $a_langpackage->a_of_album;?><label>(<?php echo str_replace('{holder}',$val['photo_num'],$a_langpackage->a_num);?>)</label></dd>

				<dd>

					<?php if(!strpos(",,$mypals,",','.$val['user_id'].',')){?>

					<img class="<?php echo $show_add_friend;?>" style="cursor:pointer;vertical-align:middle;" title="<?php echo str_replace("{he}",get_TP_pals_sex($val['user_sex']),$mp_langpackage->mp_add_mypals);?>" onclick="javascript:<?php echo str_replace("{uid}",$val['user_id'],$send_join_js);?>" src="skin/<?php echo $skinUrl;?>/images/add.gif" />

					<?php }?>

				</dd>

				<dd>

					<img style="cursor:pointer;float:right;" onclick="<?php echo $send_hi;?>(<?php echo $val["user_id"];?>)" src="skin/<?php echo $skinUrl;?>/images/hi.gif" title="<?php echo $f_langpackage->f_greet;?>" />

					<span class="app_group" style="cursor: pointer;background: url('/skin/<?php echo $skinUrl;?>/images/appbg.gif') no-repeat scroll 0 -239px transparent;float:right;width:25px;height:15px;" onclick="location='/plugins/gift/gift.php?uid=<?php echo $val["user_id"];?>&uname=<?php echo $val["user_name"];?>';">&nbsp;</span>

					<span class="app_group" style="cursor: pointer;background: url('/skin/<?php echo $skinUrl;?>/images/appbg.gif') no-repeat scroll 0 -202px transparent;float:right;width:25px;height:15px;" onclick="location='/modules2.0.php?app=msg_creator&2id=<?php echo $val["user_id"];?>&nw=2';">&nbsp;</span>

				</dd>

			</dl>

		<?php }?>

		<div class="blank"></div>

		<?php page_show($isNull,$page_num,$page_total);?>

</div>

<div id="append_parent"></div>

<div style="display: none;" class="emBg" id="face_list_menu"></div>

<script type='text/javascript'>

	set_state_view(<?php echo get_sess_online();?>);

</script>

</body>

</html><?php } ?>