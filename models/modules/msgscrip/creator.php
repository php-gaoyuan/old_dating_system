<?php
	//引入公共模块
	require("foundation/module_mypals.php");
	require("foundation/module_users.php");
	require("api/base_support.php");
	//引入语言包
	$m_langpackage=new msglp;
	$u_langpackage=new userslp;
	
	
	//变量获得
	$user_id=get_sess_userid();

	//数据表定义区
	$t_users = $tablePreStr."users";
	$t_mypals = $tablePreStr."pals_mine";

	$dbo=new dbex;
	//读写分离定义方法
    
    $one = $u_langpackage->base_user_emile_send;

    $two = $u_langpackage->base_user_emile_send2;


	// $info = $dbo->getRow("select user_group,mail_num,golds from wy_users where user_id='$user_id'");
	// 	if ($info['user_group'] == 'base') {
	// 		if ($info['mail_num'] >=3) {
	// 		    if ($info['golds'] > 1) {
	// 		        $check_acc = 1;	   	   
	// 		    } else {
	//                 $check_acc = 2;	   
	// 		    }
	// 		}
	// 	} 





	
	dbtarget('r',$dbServs);

	if(get_argg("2id")==""){
		$user_rs = getPals_mine_all($dbo,$t_mypals,$user_id);
	}
	
	$reTitle="";
	if(get_argg("rt")!=""){
		if(stripos(short_check(get_argg("rt")),"："))
		{
			$reTitle=short_check(get_argg("rt"));
		}
		else
		{
			$reTitle=$m_langpackage->m_res."：".short_check(get_argg("rt"));
		}
	}
	$have_2id="";
	$to_user_name="";
	if(get_argg("2id")!=""){
		$to_user_id=intval(get_argg("2id"));
		$to_id="<input name='2id' value='".get_argg("2id")."' type=hidden><input name='mesid' value='".get_argg("mesid")."' type=hidden>";
		$id_confirm="";
		$id_noconfirm="content_none";
		$have_2id="msToId";
		$to_user_name=get_hodler_name($to_user_id);
	}else{
		$to_id="";
		$id_confirm="content_none";
		$id_noconfirm="";
		$no_2id="msToId";
	}
	
	if(get_argg("nw")=="1"){
		$b_can="";
		$b_bak="content_none";
	}else{
		$b_can="content_none";
		$b_bak="";
	}
	$i=0;
?>