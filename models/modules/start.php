<?php
//引入心情模块公共方法
	require("foundation/module_mood.php");
	require("foundation/module_users.php");
	require("foundation/fgrade.php");
	require("foundation/fdnurl_aget.php");
	require("foundation/fpages_bar.php");
	require("api/base_support.php");
	require("foundation/auser_mustlogin.php");


//引入语言包
	//$mo_langpackage=new moodlp;
	$u_langpackage=new userslp;
    $pu_langpackage=new publiclp;
	$rf_langpackage=new recaffairlp;
	$ah_langpackage=new arrayhomelp;
    $mp_langpackage=new mypalslp;
    $im_langpackage=new impressionlp;
	$rond=get_argg('rond');
	
	$user_id=get_sess_userid();

	//数据表定义区
	//数据表定义区
	$table='';
    $t_online=$tablePreStr."online";
	$t_mood=$tablePreStr."mood";
    $t_users=$tablePreStr."users";
	$t_users_info=$tablePreStr."user_info";
	$t_users_information=$tablePreStr."user_information";

	$dbo=new dbex;
	//读写分离定义方法
	dbtarget('r',$dbServs);
	/*
	//获得最新的心情
	$last_mood_rs=get_last_mood($dbo,$t_mood,$user_id);
    //print_r($last_mood_rs);exit;
	$last_mood_txt='';
	if(isset($last_mood_rs['mood'])){
		$last_mood_txt=sub_str($last_mood_rs['mood'],35).' [<a href="modules.php?app=mood_more">'.$mo_langpackage->mo_more_label.'</a>]';
	}else{
		$last_mood_txt=$mo_langpackage->mo_null_txt;
	}
	*/
	$lovemes="";
	if(!empty($rond))
	{
		$rf_langpackage->rf_hylb=$rf_langpackage->rf_onelove;
		$lovemes='<div class="gray mt20">'.$rf_langpackage->rf_mess.'</div>';
	}

	$user_info=api_proxy("user_self_by_uid","guest_num,integral,user_add_time,user_group,onlinetimecount",$user_id);
    //print_r($user_info);

	//$remind_rs=api_proxy("message_get","remind",1,5);//取得空间提醒
	//$remind_count=api_proxy("message_get_remind_count");//取得空间提醒数量
    //$t_users on $t_online.user_id=$t_users.user_id
	$page_num=trim(get_argg('page'));
    
  /*
    
	$sql="select  $t_users.*,$t_online.*,$t_mood.* from $t_users left join $t_online on $t_users.user_id=$t_online.user_id  left join $t_mood on $t_users.user_id=$t_mood.user_id where $t_users.user_id=$t_online.user_id   order by $t_mood.add_time desc";
	
    select $t_online.*,$t_mood.*,$t_users.* from  $t_online  left join $t_mood on $t_mood.user_id=$t_online.user_id left join $t_users on $t_users.user_id=$t_online.user_id  GROUP BY $t_online.user_id order by $t_mood.add_time desc limit 0,6	

    select * from (select $t_mood.mood,$t_users.user_id,$t_users.user_name,$t_users.user_ico,$t_users.user_group from  $t_users  left join $t_mood on $t_users.user_id=$t_mood.user_id order by $t_mood.add_time desc) as tmp GROUP BY tmp.user_id

	$online_list=$dbo->getRs($sql);
    //取出全部会员
	*/
    $sql=" select user_id,user_name,user_sex,birth_year,user_ico,user_group from  $t_users  order by user_id desc limit 6";

  
   // $page_num=trim(get_argg('page'));
   //$online_list=$dbo->getRs($sql);
    //$dbo->setPages(6,$page_num);//设置分页
    $online_list=$dbo->getRs($sql);
   //print_r($user_new_rs);exit;
  // $page_total=$dbo->totalPage;
   //echo $page_total;
   //echo  $page_num;
   //print_r($online_list);
  
//
    //验证30分钟体验时间
        $addtime = strtotime($user_info['user_add_time']);
        
        $endtime = $addtime + 30*60;

        $nowtime = time();

        if($nowtime>=$endtime || $user_info['user_sex'] ==1 ){

            if($user_info['user_group']=='base' || $user_info['user_group']=='1'){
                if($page_num>2){
                    echo "<script>alert('".$mp_langpackage->mp_quanxian."');location.href='modules.php?app=user_pay';</script>";
                    exit();
                }
            }else if($user_info['user_group']=='2'){
                if($page_num>15){
                    echo "<script>alert('".$mp_langpackage->mp_quanxian."');location.href='modules.php?app=user_pay';</script>";
                    exit();
                }
            }else{
                 
            }

        
        }

        $dbo2=new dbex();
        //定义读操作
        dbtarget('r',$dbServs);
        $now_today=intval(date('Y'));
        //循环的取出每个会员的额外信息
       
        foreach($online_list as $key=>$value){
          
            $online_info=$dbo2->getRs("select online_id from $t_online where user_id=".$value['user_id']);
           foreach($online_info as $k=>$v){
               $online_list[$key]['online_id'] = $v['online_id']; 
            }
          
 
        }
        
        //控制显示
        $isset_data="";
        $none_data="content_none";
        $isNull=0;
        if(empty($online_list)){
            $isset_data="content_none";
            $none_data="";
            $isNull=1;
        }
	
 //var_dump(page_show($isNull,$page_num,$page_total));exit;
    //$sql="select * from  $t_online  order by active_time desc";
     //echo $sql;
   //$online_list=$dbo->getRs($sql);

   	//获取用户自定义属性列表
   
	//$information_rs=array();
	$information_rs=userInformationGetList($dbo,'*');
    

    //评价印象用户列表
    $sql="select user_id,user_name,user_ico from $t_users order by rand() limit 1";
    $impression_list=$dbo->getRs($sql);
    $dbo2=new dbex();
    //定义读操作
    dbtarget('r',$dbServs);
    $now_today=intval(date('Y'));
    //循环的取出每个会员的额外信息
    /*
    foreach($impression_list as $key=>$value){
        if(empty($value['birth_year'])){
             $impression_list[$key]['birth_year']=$mp_langpackage->mp_noyear;
        }else{
             $impression_list[$key]['birth_year']=$now_today-$value['birth_year'].$mp_langpackage->mp_years;
        }
        $extra_info=$dbo2->getRs("select info_id,info_value from $t_users_info where user_id=".$value['user_id']);
        
        foreach($extra_info as $k=>$v){
             $impression_list[$key][$user_information_arr[$v['info_id']]]=$v['info_value'];
        }
    }
    */
    //print_r($impression_list);exit;
?>