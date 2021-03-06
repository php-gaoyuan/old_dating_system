<?php
	//引入模块公共权限过程文件
	require("foundation/fpages_bar.php");
	require("foundation/module_mypals.php");
    require("foundation/auser_mustlogin.php");

	//引入语言包
	$mp_langpackage=new mypalslp;
    $u_langpackage=new userslp;
    $pu_langpackage=new publiclp;

	$search_name=short_check(get_argg('memName'));
	$is_online=intval(get_argg('online'));
	$q_province=short_check(get_argg('q_province'));
	$q_city=short_check(get_argg('q_city'));
	$s_province=short_check(get_argg('s_province'));
	$s_city=short_check(get_argg('s_city'));
	
	$age=short_check(get_argg('age'));   
	$min_age=short_check(get_argg('min_age'));
	$max_age=short_check(get_argg('max_age'));
	$sex=short_check(get_argg('sex'));
	$type=short_check(get_argg('type'));	
	$memName=short_check(get_argg("memName"));	
	$user_id=get_sess_userid();	
	$user_name=get_sess_username();
	$user_sex=get_sess_usersex();
	$cols=" user_id <>'$user_id' ";
	$is_login=1;
	$send_script_js="location.href='modules.php?app=msg_creator&2id={uid}&nw=1';";
	$send_join_js="mypals_add({uid});";
	$error_str=$mp_langpackage->mp_no_search;
	$target="frame_content";
	if(empty($user_id)||$type=='index'){
		$is_login=0;
		$send_script_js="goLogin();";
		$send_join_js="goLogin();";
		$error_str=$mp_langpackage->mp_search_none;
		$target="";
	}
	//数据表定义区
	$table='';
	$t_users=$tablePreStr."users";
	$t_mypals=$tablePreStr."pals_mine";
	$t_pals_request=$tablePreStr."pals_request";
	$t_online=$tablePreStr."online";
    $t_mood=$tablePreStr."mood";
	$t_users_information=$tablePreStr."user_information";
    $t_users_info=$tablePreStr."user_info";
	$table=$t_users;
	$dbo=new dbex();
	//定义读操作
	dbtarget('r',$dbServs);
	//选取用户额外信息的键值对
	$user_information_list=$dbo->getRs("select info_id,info_name from $t_users_information");
	$user_information_arr=array();
	foreach($user_information_list as $value){
		$user_information_arr[$value['info_id']]=$value['info_name'];
	}

	//取出当前用户信息
    $user_info=$dbo->getRow("select user_id,user_name,user_sex,birth_year,user_group,user_add_time from $t_users where user_id=$user_id");
	$info=get_argg('info');
	$ids="";
   
	if(is_array($info)&&$info[14]!='请选择'&&$info[14]!='All')
	{
		$ids=array();
		$ids2=$dbo->getRs("select * from wy_user_info where info_id=14 and info_value='$info[14]'");
		foreach($ids2 as $idr)
		{
			$ids[]=$idr['user_id'];
		}
		$ids=implode(",",$ids);
	}

	$now_year=date('Y');
	if($memName!=''){
		$cols.=" and user_name like '%$search_name%' ";
	}
	
	if($q_province!=$mp_langpackage->mp_province && $q_province!='' && $q_province!=$mp_langpackage->mp_none_limit){
		$cols.=" and (birth_province like '%$q_province%') ";
	}
	if($s_province!=$mp_langpackage->mp_province && $s_province!='' && $s_province!=$mp_langpackage->mp_none_limit){
		$cols.=" and (reside_province like '%$s_province%') ";
	}
	
	if($q_city!=$mp_langpackage->mp_city && $q_city!='' && $q_city!=$mp_langpackage->mp_none_limit){
		$cols.=" and (birth_city like '%$q_city%') ";
	}
	if($s_city!=$mp_langpackage->mp_city && $s_city!='' && $s_city!=$mp_langpackage->mp_none_limit){
		$cols.=" and (reside_city like '%$s_city%') ";
	}
	
	if($sex!=''){
		$cols.=" and user_sex=$sex ";
	}
	if($age){
		$age=explode('|',$age);
		$cols.=" and $now_year-birth_year BETWEEN $age[0] and $age[1] ";
	}
	if($is_online==1){
		$table=$t_online;
		$cols.=" and hidden = 0 ";
	}
	$page_num=trim(get_argg('page'));

	if(!empty($ids))
	{
		$sql="select user_id,user_name,user_sex,birth_year,birth_province,birth_city,reside_province,reside_city,user_ico,user_group from $table where $cols and user_id in($ids)";
	}
	else
	{
		$sql="select user_id,user_name,user_sex,birth_province,birth_year,birth_city,reside_province,reside_city,user_ico,user_group from $table where $cols ";
	}

	 $dbo->setPages(12,$page_num);//设置分页
	$search_rs=$dbo->getRs($sql); 
   // print_r($search_rs);exit;
    //取出心情列表
   
	$dbo2=new dbex();
	//定义读操作
	dbtarget('r',$dbServs);
 /*
    foreach($search_rs as $k=>$v){
       
      
        $sql="select mood from $t_mood where user_id=".$v['user_id'];
        //echo $sql;
       // exit;
        $modeinfo = $dbo2->getRow($sql);
        $search_rs[$k]['mood'] = $modeinfo['mood'];
    }

   */
	//print_r($search_rs);exit;
  	$now_today=intval(date('Y'));
	//循环的取出每个会员的额外信息
	foreach($search_rs as $key=>$value){
		
		
        $online_info=$dbo2->getRs("select online_id from $t_online where user_id=".$value['user_id']);
        foreach($online_info as $k=>$v){
               $search_rs[$key]['online_id'] = $v['online_id']; 
          }
		
	}   
   
	$page_total=$dbo->totalPage;//分页总数
	//控制显示
		$isset_data="";
		$none_data="content_none";
		$isNull=0;
	if(empty($search_rs)){
		$isset_data="content_none";
		$none_data="";
		$isNull=1;
	}

    //验证40分钟体验时间
        $addtime = strtotime($user_info['user_add_time']);
        
        $endtime = $addtime + 60*60;

        $nowtime = time();

        if($nowtime>=$endtime || $user_info['user_sex'] ==1 ){

            if($user_info['user_group']=='base' || $user_info['user_group']=='1'){
                if($page_num>2){
                    echo "<script>alert('".$mp_langpackage->mp_quanxian."');history.back();</script>";
                    exit();
                }
            }else if($user_info['user_group']=='2'){
                if($page_num>15){
                    echo "<script>alert('".$mp_langpackage->mp_quanxian."');history.back();</script>";
                    exit();
                }
            }else{
                 
            }

        
        }
	?>