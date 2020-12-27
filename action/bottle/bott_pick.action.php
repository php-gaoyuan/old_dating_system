<?php
	//引入模块公共方法文件
	require("foundation/aanti_refresh.php");
	require("foundation/goodlefanyi.php");
	require("api/base_support.php");

	//引入语言包
	$m_langpackage=new msglp;
	$b_langpackage=new bottlelp;

  //数据表定义
  $t_users = $tablePreStr."users";
  $t_bottle = $tablePreStr."bottle";

 
  $dbo = new dbex;
  //读写分离定义函数
  dbtarget('r',$dbServs);
  $user_id=get_sess_userid();//发件人id

  //判断是否为普通用户
  $user_info = $dbo->getRow("select user_name,user_group,user_add_time from $t_users where user_id=$user_id");

        //验证30分钟体验时间
        $addtime = strtotime($user_info['user_add_time']);
        
        $endtime = $addtime + 30*60;

        $nowtime = time();

        if($nowtime>=$endtime){
              if($user_info['user_group']=='base' || $user_info['user_group']=='1'){
                    action_return(1,$b_langpackage->b_quanxian,'modules2.0.php?app=user_pay');
                    exit();
              }
              $oneBottle=$dbo->getRow("select * from $t_bottle where bott_reid=0 and sink=1 order by rand() limit 0,1");
              
              if(!empty($oneBottle)){
                  $to_user_id=get_sess_userid();//发件人id
                  $to_user=get_sess_username();//发件人姓名
                  $to_user_ico = get_sess_userico(); 	
                  $sink=0;
                  dbtarget('r',$dbServs);
                  
                  $sql="update $t_bottle set to_user_id='$to_user_id',to_user='$to_user',to_user_ico='$to_user_ico',sink='$sink' where bott_id=".$oneBottle['bott_id'];
                 
                  if($dbo->exeUpdate($sql)){
                      action_return(1,$b_langpackage->b_find,'');
                  }else{
                      action_return(0,$b_langpackage->b_nofind,'-1');
                  }
              }else{
                  action_return(0,$b_langpackage->b_nofind2,'-1');
              }
        }else{
        
              $oneBottle=$dbo->getRow("select * from $t_bottle where bott_reid=0 and sink=1 order by rand() limit 0,1");
              
              if(!empty($oneBottle)){
                  $to_user_id=get_sess_userid();//发件人id
                  $to_user=get_sess_username();//发件人姓名
                  $to_user_ico = get_sess_userico(); 	
                  $sink=0;
                  dbtarget('r',$dbServs);
                  
                  $sql="update $t_bottle set to_user_id='$to_user_id',to_user='$to_user',to_user_ico='$to_user_ico',sink='$sink' where bott_id=".$oneBottle['bott_id'];
                 
                  if($dbo->exeUpdate($sql)){
                      action_return(1,$b_langpackage->b_find,'');
                  }else{
                      action_return(0,$b_langpackage->b_nofind,'-1');
                  }
              }else{
                  action_return(0,$b_langpackage->b_nofind2,'-1');
              }
        
        }

?>