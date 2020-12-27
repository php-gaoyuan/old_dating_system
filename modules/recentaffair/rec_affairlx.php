<?php
	require("foundation/fcontent_format.php");
	require("foundation/fgrade.php");
	require("api/base_support.php");
	require("foundation/module_mypals.php");
	require("foundation/module_users.php");
	
	//引入语言包
	$rf_langpackage=new recaffairlp;
	$mp_langpackage=new mypalslp;
	$f_langpackage=new friendlp;

	//变量取得
	$limit_num=0;
	$user_id=get_sess_userid();
	$sex=get_sess_usersex();
	$mypals=get_sess_mypals();
	$ra_rs = array();
	$looklike=get_argg('looklike');
	
	//数据表定义区
	$t_rec_affair=$tablePreStr."recent_affair";
	$t_online=$tablePreStr."online";
	
	//数据库读操作
	$dbo=new dbex;
	dbtarget('r',$dbServs);	

	$send_join_js="parent.mypals_add({uid})";
	$send_hi="parent.hi_action";

	if($looklike=='looklike'){
		$start_num=intval(get_argg('start_num'));
		//是否开启更多
		$is_more=intval($start_num/5);
		$pals_id=api_proxy("user_self_by_friend",$sex,$is_more*$mainAffairNum,$mainAffairNum);
		$looklike=get_argg('looklike');
	
		$limit_num=$mainAffairNum;
		$ra_mod_type='';
		$hidden_button_over="feed_menu({id},1);";
		$hidden_button_out="feed_menu({id},0);";
		if(is_array($pals_id)){
			foreach($pals_id as $p_id)
			{
				$sql = "select content from $t_rec_affair where user_id='$p_id[user_id]' and mod_type='6' order by id desc limit 1";
				$ra_rs_part=$dbo->getRow($sql);
				if($ra_rs_part)
				{
					$p_id['content']=$ra_rs_part['content'];
				}
				else
				{
					$p_id['content']=$rf_langpackage->rf_nomood;
				}

				$user_online=get_user_online_state($dbo,$t_online,$p_id['user_id']);

				if(empty($user_online)){
					$ol_state_ico="skin/$skinUrl/images/offline.gif";
				}else{
					$ol_state_ico="skin/$skinUrl/images/online.gif";
				}

				$p_id['ol_state_ico']=$ol_state_ico;

				if($p_id['user_group']=='1'||empty($p_id['user_group']))
				{
					$p_id['mtype']="";
				}
				else
				{
					$p_id['mtype']='&nbsp;<img width="16" height="14" src="skin/'.$skinUrl.'/images/xin/0'.$p_id['user_group'].'.gif"/>&nbsp;';
				}

				$ra_rs[]=$p_id;
			}
		}
	}
	else if($looklike=='rond')
	{
		$sql = "select * from $t_online where user_sex!='$sex'";
		$online=$dbo->getRs($sql);
		$ol_state_ico="skin/$skinUrl/images/online.gif";

		if(!$online)
		{
			$sql = "select * from wy_users where user_sex!='$sex'";
			$online=$dbo->getRs($sql);
			$ol_state_ico="skin/$skinUrl/images/offline.gif";
		}
		$start=array_rand($online,1);
		$online=$online[$start];
		$sql = "select content from $t_rec_affair where user_id='$online[user_id]' and mod_type='6' order by id desc limit 1";
		$ra_rs_part=$dbo->getRow($sql);
		if($ra_rs_part)
		{
			$online['content']=$ra_rs_part['content'];
		}
		else
		{
			$online['content']=$rf_langpackage->rf_nomood;
		}

		$online['ol_state_ico']=$ol_state_ico;

		if($online['user_group']=='base'||empty($online['user_group']))
		{
			$online['mtype']="";
		}
		else
		{
			$online['mtype']='&nbsp;<img width="16" height="14" src="skin/'.$skinUrl.'/images/xin/0'.$online['user_group'].'.gif"/>&nbsp;';
		}

		$ra_rs[]=$online;

		echo "<script>hidden_obj('affair_info');</script>";
	}
?><?php foreach($ra_rs as $rs){?>
<li id="feed_2" style="padding-left:97px;padding-right:15px;">
	<div style="float: left;margin-left: -93px;position: absolute;border:2px #EEEEEE solid;">
		<a href="home2.0.php?h=<?php echo $rs['user_id'];?>" target="_blank" title="<?php echo $rf_langpackage->rf_v_home;?>"><img src='<?php echo str_replace("_small","",$rs["user_ico"]);?>' style="height:80px;vertical-align:middle;" /></a>
	</div>
  <div class="details">
  	<div style="height:28px;"><h3 style="float:left;"><?php echo $rs["user_name"];?><?php echo $rs["mtype"];?></h3>
	<?php if(!strpos(",,$mypals,",','.$rs['user_id'].',')){?>
	<img class="<?php echo $show_add_friend;?>" style="cursor:pointer;float:right;vertical-align:middle;" title="<?php echo str_replace("{he}",get_TP_pals_sex($rs['user_sex']),$mp_langpackage->mp_add_mypals);?>" onclick="javascript:<?php echo str_replace("{uid}",$rs['user_id'],$send_join_js);?>" src="skin/<?php echo $skinUrl;?>/images/add.gif" />
	<?php }?>
	<img style="cursor:pointer;float:right;" src="<?php echo $rs['ol_state_ico'];?>" />
	</div>
    <div class="content" style="padding:5px 5px;height:15px;">
	<span style="float:left;" title="<?php echo count_level($rs['onlinetimecount']);?>"><?php echo grade($rs['onlinetimecount']);?></span>
	<img style="cursor:pointer;float:right;" onclick="<?php echo $send_hi;?>(<?php echo $rs["user_id"];?>)" src="skin/<?php echo $skinUrl;?>/images/hi.gif" title="<?php echo $f_langpackage->f_greet;?>" />
	<span class="app_group" style="cursor: pointer;background: url('/skin/<?php echo $skinUrl;?>/images/appbg.gif') no-repeat scroll 0 -239px transparent;float:right;width:25px;height:15px;" onclick="location='/plugins/gift/gift.php?uid=<?php echo $rs["user_id"];?>&uname=<?php echo $rs["user_name"];?>';">&nbsp;</span>
	<span class="app_group" style="cursor: pointer;background: url('/skin/<?php echo $skinUrl;?>/images/appbg.gif') no-repeat scroll 0 -202px transparent;float:right;width:25px;height:15px;" onclick="location='/modules2.0.php?app=msg_creator&2id=<?php echo $rs["user_id"];?>&nw=2';">&nbsp;</span>
	</div>
	<div id="replycontent_6_1">
		<p style="background-color:#eee;padding:5px 5px;"><?php echo filt_word(get_face($rs['content']));?></p>
	</div>
  </div>
</li>
<?php }?>