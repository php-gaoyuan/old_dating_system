<?php 
	//引入模块公共权限过程文件
	require("foundation/fpages_bar.php");
	require("foundation/module_mypals.php");
    require("foundation/auser_mustlogin.php");

	//引入语言包
	$mp_langpackage=new mypalslp;
    $u_langpackage=new userslp;
    $pu_langpackage=new publiclp;
	
	//数据表定义区
	$table='';
    $t_online=$tablePreStr."online";
	$t_users=$tablePreStr."users";
	$t_users_info=$tablePreStr."user_info";
	$t_users_information=$tablePreStr."user_information";
    $t_mood=$tablePreStr."mood";

	$dbo=new dbex();
	//定义读操作
	dbtarget('r',$dbServs);
	

	/*
	//选取用户额外信息的键值对
	$user_information_list=$dbo->getRs("select info_id,info_name from $t_users_information");
	$user_information_arr=array();
	foreach($user_information_list as $value){
		$user_information_arr[$value['info_id']]=$value['info_name'];
	}
	*/
	$page_num=trim(get_argg('page'));
	//$sql="select * from (select $t_users.user_id,$t_users.user_name,$t_users.user_sex,$t_users.user_ico,$t_users.birth_year,$t_users.user_group,$t_users.user_add_time,$t_mood.mood from $t_users left join $t_mood on $t_users.user_id=$t_mood.user_id  order by $t_mood.add_time desc) as tmp group by tmp.user_id order by tmp.user_add_time desc limit 12";
		
	$sql="select user_id,user_name,user_sex,birth_year,user_ico,user_group from $t_users order by user_id desc limit 12";
	//$dbo->setPages(12,$page_num);//设置分页
	$user_new_rs=$dbo->getRs($sql);
	
	//$page_total=$dbo->totalPage;//分页总数
	
	
	$dbo2=new dbex();
	//定义读操作
	dbtarget('r',$dbServs);
	$now_today=intval(date('Y'));
	//循环的取出每个会员的额外信息
	foreach($user_new_rs as $key=>$value){
		
        $online_info=$dbo2->getRs("select online_id from $t_online where user_id=".$value['user_id']);
         foreach($online_info as $k=>$v){
               $user_new_rs[$key]['online_id'] = $v['online_id']; 
            }
		
	}
	
   // print_r($user_new_rs);
	//控制显示
	$isset_data="";
	$none_data="content_none";
	$isNull=0;
	if(empty($user_new_rs)){
		$isset_data="content_none";
		$none_data="";
		$isNull=1;
	}	

?>