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
  $from_user_id=get_sess_userid();//发件人id
  //判断是否为普通用户
  $user_info = $dbo->getRow("select user_name,user_group from $t_users where user_id=$from_user_id");
  // echo $user_info['user_group'];exit;
  /*
  if($user_info['user_group']=='base' || $user_info['user_group']=='1'){
        action_return(1,'漂流瓶功能暂不对普通用户开放，请升级高级会员','modules2.0.php?app=user_pay');
        exit();
  }
  */
  //获取网站当前会员数
  $sql="select count(*) as s from $t_users";
  $user_sum=$dbo->getRow($sql);
  $rand_num=$user_sum['s']+intval($user_sum['s']/5);
  
  $bott_reid=0;
  $to_user_id=mt_rand(1,$rand_num);//收件人id
  $to_user_name='';
  $to_user_ico='';
  $sink=1;
  $addtime=date('Y-m-d H:i:s');
  
  $oneUser=$dbo->getRow("select user_id,user_name,user_ico from $t_users where user_id=$to_user_id");
  
  //如果找到用户信息,就设置漂流瓶的接受者信息
  if(!empty($oneUser)){
  	  $to_user_id=$oneUser['user_id'];
  	  $to_user_name=$oneUser['user_name'];
  	  $to_user_ico=$oneUser['user_ico'];
  	  $sink=0;
  }
  

  $from_user_name=get_sess_username();//发件人姓名
  $from_user_ico = get_sess_userico();

  dbtarget('w',$dbServs);
  $sql="insert into $t_bottle (bott_reid,bott_title,bott_content,from_user_id,from_user,from_user_ico,to_user_id,to_user,to_user_ico,kind,sink,readed,addtime) 
  values ('$bott_reid','$bott_title','$bott_content','$from_user_id','$from_user_name','$from_user_ico','$to_user_id','$to_user_name','$to_user_ico','$kind','$sink',0,'$addtime')";
  
  if($dbo->exeUpdate($sql)){
  	  if($sink==0){
  	  	  //action_return(1,'您的漂流瓶漂到了'.rand(1,10000).'公里的海岸!','-1');
          echo "<script type='text/javascript'>alert('".str_replace('{range}',rand(1,10000),$b_langpackage->b_range)."');window.close();</script>";
  	  }else{
  	  	  //action_return(1,'您扔的漂流瓶石沉大海了','-1');
          echo "<script type='text/javascript'>alert('".$b_langpackage->b_range2."');window.close();</script>";
  	  }
  }else{
  	  action_return(0,$b_langpackage->b_fail,'-1');
  }
?>

