<?php
	header("content-type:text/html;charset=utf-8");
  //引入模块公共方法文件
  require("foundation/fcontent_format.php");
  require("api/base_support.php");
  require("foundation/aanti_refresh.php");
  require("foundation/aintegral.php");

	//引入语言包
	$b_langpackage=new bloglp;

	//变量取得
    //$flag = $_GET['flag'] + 0;

	$user_id=get_sess_userid();
	$user_name=get_sess_username();
	$uico_url=get_sess_userico();//用户头像



	//数据表定义区
	$t_impression=$tablePreStr."impression";
	$t_users=$tablePreStr."users";
	$dbo=new dbex();
	//定义读操作
	dbtarget('r',$dbServs);
	
	//取出当前用户信息
    $user_info=$dbo->getRow("select user_id,user_name,user_ico,user_group,user_add_time from $t_users where user_id=$user_id");

      
    $content =$_GET['content'];
  	$content=iconv("GB2312", "UTF-8", $content);

    //echo $content;
	//print_r($_GET);exit;
    $to_user_id = $_GET['to_user_id']+0;
    $time = time();
    
    $flag='';

    //$sign_addtime = time();
	//读写分离定义函数
	$dbo = new dbex;
	dbtarget('w',$dbServs);
    $sql="insert into $t_impression (from_user_id,to_user_id,content,flag,addtime) values ($user_id,$to_user_id,'$content',0,$time)";
    if(!$dbo->exeUpdate($sql)){
        echo $flag=0;
    }else{
        echo $flag=1;
    }
	//action_return(1,'','modules2.0.php?app=ask');
?>