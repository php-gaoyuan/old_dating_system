<?php
	//引入模块公共权限过程文件
	require("foundation/fpages_bar.php");
	require("api/base_support.php");
	
	//引入语言包
	$m_langpackage=new msglp;
	$b_langpackage=new bottlelp;
	
	//变量获得
	$user_id=get_sess_userid();
	$bott_id=trim(get_argg('id'));
	
	//当前页面参数
	$page_num=trim(get_argg('page'));
	
	print_r($page_num);

	//数据表定义区
	$t_bottle=$tablePreStr."bottle";

	$dbo=new dbex;
	//读写分离定义方法
	dbtarget('r',$dbServs);
	
	$oneBottle=$dbo->getRow("select * from $t_bottle where (to_user_id=$user_id or from_user_id=$user_id) and bott_id=$bott_id");
	
	//获取主题id下的所有漂流瓶
	$sql="select * from $t_bottle where (to_user_id=$user_id or from_user_id=$user_id) and bott_reid=$bott_id";
	
	$dbo->exeUpdate("update $t_bottle set readed=1 where bott_id=$bott_id and bott_reid=0");
	$dbo->setPages(10,$page_num);
	
	$bottle_re_list=$dbo->getRs($sql);
	
	if($page_num==''){
		array_unshift($bottle_re_list,$oneBottle);
	}
	
	$page_total=$dbo->totalPage;
		
	
	$isNull=0;
	$content_data_none="content_none";
	$show_data="";
	if(empty($bottle_re_list)){
		$isNull=1;
		$show_data="content_none";
		$content_data_none="";
	}
?>