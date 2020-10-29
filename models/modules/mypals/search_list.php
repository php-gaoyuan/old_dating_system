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
    $user_id=get_sess_userid();


	$dbo=new dbex();
	//定义读操作
	dbtarget('r',$dbServs);
	//在线会员个数
    $online=$dbo->getRow("select count(*) as num from $t_online");
    $online_count = $online['num'];
	//取出当前用户信息
    $user_info=$dbo->getRow("select user_id,user_name,user_sex,user_group,user_add_time from $t_users where user_id=$user_id");


        //本周达人
        $super_user_list=$dbo->getRs("select * from $t_users order by guest_num desc limit 0,4");
        
        //商城礼物
        $gift_list=$dbo->getRs("select patch,giftname from gift_news order by rand() limit 0,4");
        //取出当前用户信息
        $user_info=$dbo->getRow("select user_id,user_name,user_group,user_add_time from $t_users where user_id=$user_id");
        //print_r($user_info);
        //选取用户额外信息的键值对
		/*
        $user_information_list=$dbo->getRs("select info_id,info_name from $t_users_information");
        $user_information_arr=array();
        foreach($user_information_list as $value){
            $user_information_arr[$value['info_id']]=$value['info_name'];
        }
		*/
        $page_num=trim(get_argg('page'));
        $sql="select user_id,user_name,user_sex,birth_year,user_ico,user_group from $t_users order by user_id desc";
            
        $dbo->setPages(20,$page_num);//设置分页
        $user_new_rs=$dbo->getRs($sql);
       //print_r($user_new_rs);exit;
       $page_total=$dbo->totalPage;

    //验证30分钟体验时间
        $addtime = strtotime($user_info['user_add_time']);
        
        $endtime = $addtime + 30*60;

        $nowtime = time();
        
        if($nowtime>=$endtime || $user_info['user_sex'] ==1 ){

            if($user_info['user_group']=='base' || $user_info['user_group']==1){
                if($page_num>2){
                    echo "<script>alert('".$mp_langpackage->mp_quanxian."');location.href='main.php?app=user_pay';</script>";
                    exit();
                }
            }else if($user_info['user_group']=='2'){
                if($page_num>15){
                    echo "<script>alert('".$mp_langpackage->mp_quanxian."');location.href='main.php?app=user_pay';</script>";
                    exit();
                }
            }else{
                 
            }
        
        }

        /*
        $dbo2=new dbex();
        //定义读操作
        dbtarget('r',$dbServs);
        $now_today=intval(date('Y'));
        //循环的取出每个会员的额外信息
        foreach($user_new_rs as $key=>$value){
            if(empty($value['birth_year'])){
                $user_new_rs[$key]['birth_year']=$mp_langpackage->mp_noyear;
            }else{
                $user_new_rs[$key]['birth_year']=$now_today-$value['birth_year'].$mp_langpackage->mp_years;
            }
            $extra_info=$dbo2->getRs("select info_id,info_value from $t_users_info where user_id=".$value['user_id']);
             $online_info=$dbo2->getRs("select online_id from $t_online where user_id=".$value['user_id']);
           foreach($online_info as $k=>$v){
               $user_new_rs[$key]['online_id'] = $v['online_id']; 
            }
            foreach($extra_info as $k=>$v){
                $user_new_rs[$key][$user_information_arr[$v['info_id']]]=$v['info_value'];
            }
        }
		*/
		
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