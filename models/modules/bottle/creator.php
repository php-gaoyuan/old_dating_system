<?php

	
	//引入公共模块
	require("foundation/module_mypals.php");
	require("foundation/module_users.php");
	require("api/base_support.php");
	//引入语言包
	$m_langpackage=new msglp;
	$b_langpackage=new bottlelp;
	//变量获得
	$user_id=get_sess_userid();
  //数据表定义
  $t_users = $tablePreStr."users";
  $dbo = new dbex;
  //读写分离定义函数
  dbtarget('r',$dbServs);
  //判断是否为普通用户
  $user_info = $dbo->getRow("select user_name,user_group,user_sex,user_add_time from $t_users where user_id=$user_id");
       if(($user_info['user_group']=='base' || $user_info['user_group']=='1')&&$user_info['user_sex']=='0'){
               
                echo "<script type='text/javascript'>alert('".$b_langpackage->b_quanxian."');location.href='modules.php?app=user_pay';</script>";
                exit();
        }
        //验证30分钟体验时间
        $addtime = strtotime($user_info['user_add_time']);
        
        $endtime = $addtime + 30*60;

        $nowtime = time();

        if($nowtime>=$endtime){

          if($user_info['user_group']=='base' || $user_info['user_group']=='1'){
               
                echo "<script type='text/javascript'>alert('".$b_langpackage->b_quanxian."');location.href='modules.php?app=user_pay';</script>";
                exit();
          }
        }

    $king = $_GET['king'];

    //echo $king;exit;
?>