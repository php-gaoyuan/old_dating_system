<?php
	require("foundation/fpages_bar.php");
	require("foundation/module_mypals.php");
    require("foundation/auser_mustlogin.php");
	//引入语言包
	$mp_langpackage=new mypalslp;
    $u_langpackage=new userslp;
    $pu_langpackage=new publiclp;
	
	//数据表定义区
	$table='';
	$t_users=$tablePreStr."users";
    $t_online=$tablePreStr."online";
	$t_users_info=$tablePreStr."user_info";
	$t_users_information=$tablePreStr."user_information";
    $user_id=get_sess_userid();
    
	$dbo=new dbex();
	//定义读操作
	dbtarget('r',$dbServs);
	
		//取出当前用户信息
    $user_info=$dbo->getRow("select user_id,user_name,user_sex,user_group,user_add_time from $t_users where user_id=$user_id");
	
	if(empty($user_info)){
		echo "<script type='text/javascript'>alert('{$pu_langpackage->pu_lockdel}');location.href='do.php?act=logout';</script>";
	}
	
	//选取用户额外信息的键值对
	$user_information_list=$dbo->getRs("select info_id,info_name from $t_users_information");


	$page_num=trim(get_argg('page'));
	$sql="select $t_online.user_id,$t_online.user_name,$t_online.hidden,$t_users.user_group,$t_users.birth_year,$t_users.user_sex,$t_users.user_ico  from $t_online left join $t_users on $t_online.user_id=$t_users.user_id order by active_time desc";
		
	$dbo->setPages(20,$page_num);//设置分页
	$online_list=$dbo->getRs($sql);
	//$online_count = count($online_list);
    
   $page_total=$dbo->totalPage;
    //验证30分钟体验时间
        $addtime = strtotime($user_info['user_add_time']);
        
        $endtime = $addtime + 30*60;

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
        $dbo2=new dbex();
        //定义读操作
        dbtarget('r',$dbServs);
        $now_today=intval(date('Y'));
        //循环的取出每个会员的额外信息
        foreach($online_list as $key=>$value){
            if(empty($value['birth_year'])){
                $online_list[$key]['birth_year']=$mp_langpackage->mp_noyear;
            }else{
                $online_list[$key]['birth_year']=$now_today-$value['birth_year'].$mp_langpackage->mp_years;
            }
            $extra_info=$dbo2->getRs("select info_id,info_value from $t_users_info where user_id=".$value['user_id']);
            
            foreach($extra_info as $k=>$v){
                $online_list[$key][$user_information_arr[$v['info_id']]]=$v['info_value'];
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
	//在线会员个数
    $online=$dbo->getRow("select count(*) as num from $t_online");
    $online_count = $online['num'];
	
	?>