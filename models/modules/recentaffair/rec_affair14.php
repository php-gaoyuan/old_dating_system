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

		$sql = "select r.* from wy_recent_affair r,wy_users u where r.user_id=u.user_id and u.user_sex !=$sex and r.mod_type in(3) order by r.id desc limit $start,$mainAffairNum";

		$ra_rs_part=$dbo->getRs($sql);
		$ra_rs=array_merge($ra_rs,$ra_rs_part);
	}
?>