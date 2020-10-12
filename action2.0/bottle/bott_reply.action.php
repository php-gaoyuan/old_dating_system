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
  
  //变量获得
  $kind=$_POST['kind'];
  $bott_title=$_POST['title'];
  $bott_content=$_POST['content'];
  $bott_reid=$_POST['reid'];
  
  $reBottle=$dbo->getRow("select * from $t_bottle where bott_id=$bott_reid and bott_reid=0");
  
  if(empty($reBottle)){
  	action_return(0,$b_langpackage->b_nobottle,'-1');
  }
  
  if($reBottle['to_user_id']==get_sess_userid()){//收到的主题瓶
	  $to_user_id=$reBottle['from_user_id'];//收件人id
	  $to_user_name=$reBottle['from_user'];
	  $to_user_ico=$reBottle['from_user_ico'];  	
  }else{										//抛出的主题瓶
	  $to_user_id=$reBottle['to_user_id'];//收件人id
	  $to_user_name=$reBottle['to_user'];
	  $to_user_ico=$reBottle['to_user_ico'];  	
  }
  
  $sink=0;
  $addtime=date('Y-m-d H:i:s');
  
  $from_user_id=get_sess_userid();//发件人id
  $from_user_name=get_sess_username();//发件人姓名
  $from_user_ico = get_sess_userico();

  dbtarget('w',$dbServs);
  $sql="insert into $t_bottle (bott_reid,bott_title,bott_content,from_user_id,from_user,from_user_ico,to_user_id,to_user,to_user_ico,kind,sink,readed,addtime) 
  values ('$bott_reid','$bott_title','$bott_content','$from_user_id','$from_user_name','$from_user_ico','$to_user_id','$to_user_name','$to_user_ico','$kind','$sink',0,'$addtime')";
  
  if($dbo->exeUpdate($sql)){
  	  action_return(1,$b_langpackage->b_reply_s,'modules.php?app=bott_rpshow&id='.$reBottle['bott_id']);
  }else{
  	  action_return(0,$b_langpackage->b_reply_f,'-1');
  }
?>

