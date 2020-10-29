<?php
	//引入模块公共权限过程文件
	require("foundation/fpages_bar.php");
	require("api/base_support.php");
	
	//引入语言包
	$m_langpackage=new msglp;
	$b_langpackage=new bottlelp;
	
	//变量获得
	$user_id=get_sess_userid();
	
	//当前页面参数
	$page_num=trim(get_argg('page'));

	//数据表定义区
	$t_bottle=$tablePreStr."bottle";

	$dbo=new dbex;
	//读写分离定义方法
	dbtarget('r',$dbServs);
	
	$sql="select * from $t_bottle where to_user_id=$user_id and bott_reid=0 order by addtime desc";
	
	$dbo->setPages(20,$page_num);
	
	$bottle_list=$dbo->getRs($sql);
	
	$page_total=$dbo->totalPage;
		
	
	$isNull=0;
	$content_data_none="content_none";
	$show_data="";
	if(empty($bottle_list)){
		$isNull=1;
		$show_data="content_none";
		$content_data_none="";
	}
?>