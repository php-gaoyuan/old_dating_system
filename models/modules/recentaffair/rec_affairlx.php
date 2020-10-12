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

				if($p_id['user_group']=='base'||empty($p_id['user_group']))
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
?>