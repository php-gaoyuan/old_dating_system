<?php
	require("api/base_support.php");
	//require("foundation/module_users.php");
    $ah_langpackage=new arrayhomelp;
    $gu_langpackage=new guestlp;
    $pu_langpackage=new publiclp;
    $a_langpackage=new albumlp;
    dbtarget('r',$dbServs);
	$dbo=new dbex;
	//获取用户自定义属性列表
	$url_uid= intval(get_argg('user_id'));
	$ses_uid=get_sess_userid();
	$guest_user_name=get_sess_username();
	$guest_user_ico=get_sess_userico();
	$mypals=get_sess_mypals();
    //引入模块公共权限过程文件
	$is_login_mode='';
	$is_self_mode='partLimit';
	

	//数据表定义区
	$t_guest = $tablePreStr."guest";
	$t_users = $tablePreStr."users";

	
    
	
	//加为好友 打招呼
	$add_friend="mypalsAddInit";
	$send_hi="hi_action";
	if(!$ses_uid){
	  	$add_friend='goLogin';
	  	$send_hi='goLogin';
	}
	
	//读写分离定义方法
	$guest_rs = api_proxy("guest_self_by_uid","*",$userid,6); 



	$sql3="select id,user_id,pals_id,pals_sort_id,pals_sort_name,pals_name,pals_sex,add_time,pals_ico,accepted,active_time from wy_pals_mine where user_id=$user_id and accepted > 0 limit 0,9";
	$mp_list_rs=$dbo->getRs($sql3);

    $sql4="select user_id,user_name,user_add_time,user_sex,user_ico from wy_users where  is_recommend=1  order by user_add_time desc limit 0,4";
	$recommend_rs=$dbo->getRs($sql4);



    
?>