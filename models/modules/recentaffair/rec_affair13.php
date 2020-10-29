<?php
	require("foundation/fcontent_format.php");
	require("foundation/fgrade.php");
	require("api/base_support.php");
	require("foundation/module_mypals.php");
	
	//引入语言包
	$rf_langpackage=new recaffairlp;
	$mp_langpackage=new mypalslp;
	$f_langpackage=new friendlp;

	//变量取得
	$limit_num=0;
	$user_id=get_sess_userid();
	$sex=get_sess_usersex();
	$mypals=get_sess_mypals();
	$looklike=get_argg('looklike');
	$ra_rs = array();
	
	//数据表定义区
	$t_rec_affair=$tablePreStr."recent_affair";
	
	//数据库读操作
	$dbo=new dbex;
	dbtarget('r',$dbServs);	

	$send_join_js="parent.mypals_add({uid});";
	$send_hi="parent.hi_action";

	if($looklike=='looklike'){
		$start_num=intval(get_argg('start_num'));
		//是否开启更多
		$is_more=intval($start_num/5);
		$start=$is_more*$mainAffairNum;

		$sql = "select r.* from wy_recent_affair r,wy_users u where r.user_id=u.user_id and u.user_sex !=$sex and r.mod_type in(0,6) order by r.id desc limit $start,$mainAffairNum";

		$ra_rs_part=$dbo->getRs($sql);

		if($langPackagePara=='zh')
		{
			$ra_rs_part2=array();
			foreach($ra_rs_part as $r)
			{
				$mess=$r[2];
				$mess=str_replace("Mood update","心情更新",$mess);
				$mess=str_replace("In the album","在相册",$mess);
				$mess=str_replace("Uploaded a new photo","中上传了新照片",$mess);
				$mess=str_replace("Write a new blog","写了新日志",$mess);
				$mess=str_replace("Ask a new question","提出新问题",$mess);
				$mess=str_replace("Answer","回答",$mess);

				$mess=str_replace("Create","创建了群组",$mess);
				$mess=str_replace("Initiated a vote","发起了投票",$mess);
				$mess=str_replace("Avatar is updated to","头像更新为",$mess);

				$r[2]=$mess;
				$r['title']=$mess;
				$ra_rs_part2[]=$r;
			}
			$ra_rs_part=$ra_rs_part2;
		}
		else if($langPackagePara=='en')
		{
			$ra_rs_part2=array();
			foreach($ra_rs_part as $r)
			{
				$mess=$r[2];
				$mess=str_replace("心情更新","Mood update",$mess);
				$mess=str_replace("在相册","In the album",$mess);
				$mess=str_replace("中上传了新照片","Uploaded a new photo",$mess);
				$mess=str_replace("写了新日志","Write a new blog",$mess);
				$mess=str_replace("提出新问题","Ask a new question",$mess);
				$mess=str_replace("回答","Answer",$mess);

				$mess=str_replace("创建了群组","Create",$mess);
				$mess=str_replace("发起了投票","Initiated a vote",$mess);
				$mess=str_replace("头像更新为","Avatar is updated to",$mess);

				$r[2]=$mess;
				$r['title']=$mess;
				$ra_rs_part2[]=$r;
			}
			$ra_rs_part=$ra_rs_part2;
		}

		$ra_rs=array_merge($ra_rs,$ra_rs_part);
	}
?>