<?php

	require("api/base_support.php");





   $t_sign=$tablePreStr."sign";

	/*

	$msg_inbox_rs=api_proxy("scrip_inbox_get_mine","count(*)","",0);

	if(is_array($msg_inbox_rs[0]))

	{

		$msg_inbox_rs=$msg_inbox_rs[0][0];

	}

	else

	{

		$msg_inbox_rs=0;

	}



	$msg_notice_rs=api_proxy("scrip_notice_get","count(*)","","and readed='0'");

	if(is_array($msg_notice_rs[0]))

	{

		$msg_notice_rs=$msg_notice_rs[0][0];

	}

	else

	{

		$msg_notice_rs=0;

	}

	*/

	

	$user_id=get_sess_userid();

	$userinfo=Api_Proxy("user_self_by_uid","*",$user_id);

	if($userinfo['user_group']=='base'||empty($userinfo['user_group']))

	{

		$mtype='<img width="35" height="35" src="skin/'.$skinUrl.'/images/xin/01.gif"/>&nbsp;';

	}

	else

	{

		$mtype='<img width="35" height="35" src="skin/'.$skinUrl.'/images/xin/0'.$userinfo['user_group'].'.gif"/>&nbsp;';

	}

	

	//创建系统对数据库进行操作的对象

	$dbo=new dbex();

	//对数据进行读写分离，读操作

	dbplugin('r');

	//查询用户的礼品

	$sql="select count(*) from gift_order where is_see='0' and accept_id=".get_sess_userid();

	$gifts=$dbo->getRow($sql);

	if(is_array($gifts))

	{

		$gifts=$gifts[0];

	}

	else

	{

		$gifts=0;

	}

    //商城礼物

	$gift_list=$dbo->getRs("select id,yuanpatch,patch,giftname from gift_news order by id limit 0,4");

    //print_r($gift_list);



	$dbo=new dbex();

	//定义读操作

	dbtarget('r',$dbServs);

    //是否签到

    $sql = "select user_id,user_name,sign_flag,sign_addtime from $t_sign where user_id=$user_id order by sign_addtime desc";





      $flag=$dbo->getRow($sql);



      $stime = $flag['sign_addtime'];

       

     //echo $tmp=date('Y-m-d H:i:s',$stime);





     //echo $tmp;exit;

    $stmp = time()-$stime;

    if($flag['sign_flag']==1 && $stmp <24*60*60 ){

        $sflag=1;

    }else{

        $sflag=0;

    }

  

    

    

$sqlg = "select * from wy_users where user_id=$user_id";

	$userinfo = $dbo->getRow($sqlg);

	$sqlonline="select * from wy_online where hidden=0 and user_id=$user_id";

	$is_online=$dbo->getRow($sqlonline);

	if($is_online){$set_status=1;}else{$set_status=0;}

    if($userinfo['user_group']==2){

		$userinfo['user_tt']='Senior member';

	}

	if($userinfo['user_group']==3){

		$userinfo['user_tt']='VIP member';

	}

	//未读邮件数量

$email_count=$dbo->getRs("select readed from wy_msg_inbox where user_id='$user_id' and readed=0");

$email_num=count($email_count);

	//收到礼物数量

	$liwushuliang=$dbo->getRow("select count(id) as s from gift_order where accept_name='".get_sess_username()."'");

	$liwushuliang=$liwushuliang['s'];







	//gaoyuanadd判断用户vip是否到期，若到期更新数据

	$groups=$dbo->getRow("select `endtime` from wy_upgrade_log where mid='$user_id' and state='0' order by id desc limit 1");



	//print_r($groups);



	$startdate=strtotime(date("Y-m-d"));



	$enddate=strtotime($groups['endtime']);



	$days=round(($enddate-$startdate)/3600/24);

	//var_dump($groups);

	if($days<=0 && !$group){



		$sql="update wy_upgrade_log set state='1' where mid='$user_id'";



		$dbo->exeUpdate($sql);



		$sql="update wy_users set user_group='1'   where  user_id='$user_id'";



		$dbo->exeUpdate($sql);



	}

?>

<script>

	function set_status(sta){

		var sets=new Ajax();

		sets.getInfo("do.php","GET","app","act=set_status&sta="+sta,function(ret){

			if(sta==1){

				$('#state_hover em').html('隐身');

				$('#status_ico').attr('style',"background:url(/skin/<?php echo $skinUrl;?>/images/noonline.png) 10px center no-repeat;")

			}else{

				$('#state_hover em').html('在线');

				$('#status_ico').attr('style',"background:url(/skin/<?php echo $skinUrl;?>/images/online.png) 10px center no-repeat;")

			}

		});

		

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

<!--------左列表-------------->

<style type="text/css">





#app_nav1_lq li a{





display:inline-block;

width:88px;

height:19px;

line-height:19px;



}





</style>

<div id="left_nav_lq" class="left_nav" >

  	<dl id="personal_info_lq" class="personal-info">

  

        <dt class="head_info_lq">

        <a href="main2.0.php?app=user_ico" style="overflow: visible;">

        <img class="head_img1_lq" src="<?php if($userinfo['user_ico']){echo $userinfo['user_ico'];}else{if($userinfo['user_sex']>0){echo '/skin/'.$skinUrl.'/images/d_ico_1.gif';}else{echo '/skin/'.$skinUrl.'/images/d_ico_0.gif';}}?>"  alt="<?php echo $user_name;?>">

        <i class="christmas-adornment "></i>

        <span class="online_icon1_lq line-status-position set_status " status="1"></span>

        </a>

        </dt>

        

        

        <dd>

	      	<div class="name_box1_lq" style=" padding-right:20px">

	      		<span class="left-nav-icon vip_icon0_lq"></span>

	      		<span class="personal_name_lq">

	      			<a href="main2.0.php?app=user_info" hidefocus="true"  title="<?php echo $user_name;?>"  style=" width:auto">

	      				<?php echo filt_word(get_sess_username());?>

	      			</a>

	      		</span>

		    </div>

		    <div class="level_box1_lq">

		      	<?php if($userinfo['user_group']==2 && $days>0){echo "<img style='display:inline;' title='$userinfo[user_tt]' src='skin/default/jooyea/images/xin/gaoji.png'/>";}?>

		      	<?php if($userinfo['user_group']==3 && $days>0){echo "<img style='display:inline;' title='$userinfo[user_tt]' src='skin/default/jooyea/images/xin/vip.gif'/>";}?>

		      	<?php if($userinfo["user_group"]==4){echo "<img style='display:inline;' title='$userinfo[user_tt]'    src='skin/default/jooyea/images/xin/vip-yj.gif'/>";} ?>

		    </div>

	    </dd>

  	</dl>

	  <ul class="personal-info-2">

	    <li> <span class="per-info2-num" title="<?php echo $userinfo['golds'];?>"> <a id="member_gold_cyw"><?php echo $userinfo['golds'];?></a> </span><br>

	      <a id="js_recharge_gold" href="javascript:void(0)" class="left-nav-icon gold_icon1_lq mt5" title="金币"></a> </li>

	    <li> <span class="per-info2-num" id="red_heart_sun"><?php echo $userinfo['horn'];?></span><br>

	      <a href="javascript:void(0)" title="" class="left-nav-icon charm_icon1_lq mt5"></a> </li>

	    <li id="img"> <span class="per-info2-num"><?php echo $userinfo['integral'];?></span><br>

	      <a title=""><span class="left-nav-icon jifen_icon1_lq  mt5"></span></a> </li>

	  </ul>

  <ul id="app_nav1_lq">

    <li id="js_rc_online"> <span id="charge_icon1_dp" class="charge_icon1_lq left-nav-icon online-upgrade"></span> <a href="./main2.0.php?app=user_pay"><?php echo $u_langpackage->u_pay;?></a> </li>

    <li id="js_letter"> <span class="left-nav-icon email_icon1_lq "></span> <a id="letter_notice" href="main2.0.php?app=user_upgrade"  hidefocus="true"><?php echo $u_langpackage->u_update;?></a>

      

    </li>

    <li> <span class="left-nav-icon photo_icon1_lq"></span> <a href="main2.0.php?app=msg_minbox" hidefocus="true"><?php echo $mn_langpackage->mn_scrip;?></a>

    <?php

	

	if($email_num)

    echo '<div id="letter_num_sun" class="note_num2_lq" style="svisibility: visible;">'.$email_num.'</div>';

	

	?> </li>

    <li> <span class="left-nav-icon blog_icon1_lq"></span> <a href="<?php echo $siteDomain;?>main2.0.php?app=u_horn&active=1s"  hidefocus="true"><?php echo $u_langpackage->u_horn;?></a> <span class="blog_num1_lq"></span> </li>

    <li class="more-li js_group" > <span class="left-nav-icon group_icon1_lq"></span> <a href="main2.0.php?app=album"><?php echo $mn_langpackage->mn_album;?></a> </li>

    <li class="more-li" > <span class="left-nav-icon shares_icon1_lq"></span> <a href="main2.0.php?app=blog_list"><?php echo $mn_langpackage->mn_blog;?></a> </li>

    <li class="more-li" > <span class="left-nav-icon mood_icon1_lq"></span> <a href="main.php?app=mood_more"><?php echo $mn_langpackage->mn_mood;?></a> </li>

    <!-- <li class="more-li" > 

    	<span class="left-nav-icon mood_icon1_lq0517"></span>

    	<a href="main2.0.php?app=share_list&m=mine"><?php echo $mn_langpackage->mn_share;?></a>

    </li> -->

    <li class="more-li" > 

    	<span class="left-nav-icon mood_icon1_lq0517"></span>

    	<a href="main2.0.php?app=cash"><?php echo $mn_langpackage->mn_cash;?></a>

    </li>





    <li id="js_li_title" class="li-title">

     <!-- <label class="li-title-label">商店</label>-->

      <!--<i id="js_see_more" class="ico vactivity_icon_point"></i>--> </li>

      <li id="valentine"> <span class="left-nav-icon ico ico_flower"></span> <a style="position: relative" href="main2.0.php?app=giftshop"><?php echo $u_langpackage->u_shop;?><img src="./template/main/new3.gif" style="display: inline-block; position: absolute; top: -5px; right: -25px;"> </a> </li>

    <li> <span class="left-nav-icon gifts_icon1_lq"></span> <a href="main2.0.php?app=gift"><?php echo $u_langpackage->u_kapian;?></a> </li>

    <!--li id="valentine"> <span class="left-nav-icon ico ico_flower"></span> <a style="position: relative" href="plugins/gift/valentine.php"><?php echo $u_langpackage->u_valentine_day;?><img src="./template/main/new2.gif" style="display: inline-block; position: absolute; top: -5px; right: -25px;"> </a> </li>

    <li> <span class="left-nav-icon ico vgifts_icon "></span> <a href="main2.0.php?app=giftshop"><?php echo $u_langpackage->u_shop;?></a>    

    <?php

	

	if($liwushuliang)

    echo '<div id="letter_num_sun" class="note_num2_lq" style="svisibility: visible;">'.$email_num.'s</div>';

	

	?> 

    </li-->

<!--    <li class="js_giftNum"> <span class="left-nav-icon skin_icon1_lq"></span> <a url="/Gift/MyGiftList"> 我的礼物</a>

      <div id="gift_num_sun" class="note_num2_lq" style="visibility: hidden;"></div>

    </li>-->

    <li id="js_li_title2" class="li-title">

  <!--    <label class="li-title-label">其他</label>-->

    </li>

    <!-- <li> <span class="left-nav-icon invitation_icon1_lq"></span> <a href='<?php echo $siteDomain;?>wish'><?php echo $mn_langpackage->mn_yingyong;?></a> </li>

    <li id="mobileApp"> <span class="left-nav-icon app_icon1_download"></span> <a  href="main2.0.php?app=mypals_invite" hidefocus="true"><?php echo $mn_langpackage->mn_user_invite;?></a> </li>

    <li id="js_rz_url"> <span class="left-nav-icon  oico oico_rz"></span> <a href="main2.0.php?app=renzheng"><?php echo $mn_langpackage->mn_renzheng;?></a> </li>

    

    <li id="mobileApp">

                    <span class="left-nav-icon app_icon1_download"></span>

                    <a  href="main2.0.php?app=appdownload">APP</a>

                </li> -->

  </ul>

    <div class="left-nav-adimg"> <img src="./apk/ewm.png" width="170"  title="" alt=""> </div> 

    <p style="margin:10px 0;text-align:center">APP Download</p>

</div>



<script>

	function len(s) {//按字节计算中英文字符长度

		var l = 0;

		var a = s.split('');

		for (var i=0;i<a.length;i++) {

		 if (a[i].charCodeAt(0)<299) {

		  l++;

		 } else {

		  l+=2;

		 }

		}

		return l;

	}

</script>

<!--------左列表-------------->