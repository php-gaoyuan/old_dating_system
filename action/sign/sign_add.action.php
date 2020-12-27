<?php
  //引入模块公共方法文件
  require("foundation/fcontent_format.php");
  require("api/base_support.php");
  require("foundation/aanti_refresh.php");
  require("foundation/aintegral.php");

	//引入语言包
	$b_langpackage=new bloglp;
	$pu_langpackage=new publiclp;

	//变量取得
    $flag = $_GET['flag'] + 0;

	$user_id=get_sess_userid();
	$user_name=get_sess_username();
	$uico_url=get_sess_userico();//用户头像



	//数据表定义区
	$t_sign=$tablePreStr."sign";
	$t_users=$tablePreStr."users";
	$dbo=new dbex();
	//定义读操作
	dbtarget('r',$dbServs);
	
	//取出当前用户信息
    $user_info=$dbo->getRow("select user_id,user_name,user_ico,user_group,user_add_time from $t_users where user_id=$user_id");
    //取出当前用户签到信息
     $sign_info=$dbo->getRow("select user_id,user_name,sign_flag,sign_addtime from $t_sign where user_id=$user_id");
      

    $sign_addtime = time();
	//读写分离定义函数
	$dbo = new dbex;
	dbtarget('w',$dbServs);
    
	//判断是否签到
    if($flag==1){
        $sql = "insert into $t_sign (user_id,user_name,user_ico,sign_flag,sign_addtime) values ($user_id,'{$user_info['user_name']}','{$user_info['user_ico']}',1,$sign_addtime)";
        if(!$dbo->exeUpdate($sql)){
            action_return(0,$pu_langpackage->pu_sign_fail,-1);exit;
        }else{
            action_return(0,$pu_langpackage->pu_sign_success,'main.php');exit;
        }
    }else{
         action_return(0,$pu_langpackage->pu_sign_please,-1);exit;
    }
	//action_return(1,'','modules2.0.php?app=ask');
?>