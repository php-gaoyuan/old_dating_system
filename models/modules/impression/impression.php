<?php
	//引入模块公共权限过程文件
	require("foundation/fpages_bar.php");
	require("api/base_support.php");
	
	//引入语言包
	$m_langpackage=new msglp;
	$im_langpackage=new impressionlp;
	
	//变量获得
	$user_id=get_sess_userid();
	
	//数据表定义区
	$t_impression=$tablePreStr."impression";
    $t_users=$tablePreStr."users";
    $host_id=intval(get_argg('user_id'));
    $user_info=api_proxy("user_self_by_uid","user_ico",$host_id);
    //print_r($user_info);exit;
	$dbo=new dbex;
	//读写分离定义方法
	dbtarget('r',$dbServs);
    
    $sql="select content from $t_impression  where to_user_id=$host_id";
    
    $impression_list=$dbo->getRs($sql);
    
    
	
?>