<?php
	//引入模块公共方法文件
	require("foundation/aanti_refresh.php");
	require("foundation/goodlefanyi.php");
	require("api/base_support.php");

	//引入语言包
	$m_langpackage=new msglp;

  //变量获得
  $msgStr="";
  $msg_touser=intval(get_argp("msToId"));
  $msg_title=short_check(get_argp("msTitle"));
  $msg_txt=stripslashes(get_argp("msContent"));
  $transtype=intval(get_argp("transtype"));
  $touser_id="";//收件人id
  $touser="";//收件人name
  $tousex="";
  $user_id=get_sess_userid();//发件人id
  $user_name=get_sess_username();//发件人姓名
  $user_ico = get_sess_userico();

  $dbo = new dbex;
  //读写分离定义函数
  dbtarget('r',$dbServs);

  //数据表定义
  $t_users = $tablePreStr."users";
  $t_msg_outbox = $tablePreStr."msg_outbox";
  $t_msg_inbox = $tablePreStr."msg_inbox";

  $user_self = api_proxy("user_self_by_uid","*",$user_id);

    //验证30分钟体验时间
   $addtime = strtotime($user_self['user_add_time']);
        
   $endtime = $addtime + 30*60;

   $nowtime = time();
   //男性60分钟体验时间
if($nowtime>=$endtime && $user_info['user_sex'] =='1' )
 {  
   
  $score=1;
  if($transtype==1)
  {
	  if(intval($user_self['user_group'])<=2)
	  {
		  $length=strlen($msg_txt);
		  $score=$length>100?ceil(($length-100)/60)+1:1;
	  }
	  else
	  {
		  $sql="select count(*) as c from $t_msg_inbox where from_user_id='$user_id' and transtype='1' and transtate='1' and TO_DAYS(add_time)=TO_DAYS(now())";
		  $count=$dbo->getRow($sql);
           
		  if(intval($user_self['user_group'])==2)
		  {
			  if($count['c']<50)
			  {
				$score=0.00;
			  }
			  else
			  {
				$length=strlen($msg_txt);
				$score=$length>100?ceil(($length-100)/60)+1:1;
			  }
		  }
		  else if(intval($user_self['user_group'])==3)
		  {
			  if($count['c']<100)
			  {
				$score=0.00;
			  }
			  else
			  {
				$length=strlen($msg_txt);
				$score=$length>100?ceil(($length-100)/60)+1:1;
			  }
		  }
	  }
  }
  else
  {
	  if(intval($user_self['user_group'])>=2)
	  {
		  $score=0.00;
	  }
	  else
	  {
		  $sql="select count(*) as c from $t_msg_inbox where from_user_id='$user_id' and transtype='0' and transtate='1' and TO_DAYS(add_time)=TO_DAYS(now())";
		  $count=$dbo->getRow($sql);
		  if($count['c']<3)
		  {
			$score=0.00;
		  }
	  }
  }
}else if($user_info['user_sex']=='0'){
  $score=1;
  if($transtype==1)
  {
	  if(intval($user_self['user_group'])<=2)
	  {
		  $length=strlen($msg_txt);
		  $score=$length>100?ceil(($length-100)/60)+1:1;
	  }
	  else
	  {
		  $sql="select count(*) as c from $t_msg_inbox where from_user_id='$user_id' and transtype='1' and transtate='1' and TO_DAYS(add_time)=TO_DAYS(now())";
		  $count=$dbo->getRow($sql);
           
		  if(intval($user_self['user_group'])==2)
		  {
			  if($count['c']<50)
			  {
				$score=0.00;
			  }
			  else
			  {
				$length=strlen($msg_txt);
				$score=$length>100?ceil(($length-100)/60)+1:1;
			  }
		  }
		  else if(intval($user_self['user_group'])==3)
		  {
			  if($count['c']<100)
			  {
				$score=0.00;
			  }
			  else
			  {
				$length=strlen($msg_txt);
				$score=$length>100?ceil(($length-100)/60)+1:1;
			  }
		  }
	  }
  }
  else
  {
	  if(intval($user_self['user_group'])>=2)
	  {
		  $score=0.00;
	  }
	  else
	  {
		  $sql="select count(*) as c from $t_msg_inbox where from_user_id='$user_id' and transtype='0' and transtate='1' and TO_DAYS(add_time)=TO_DAYS(now())";
		  $count=$dbo->getRow($sql);
		  if($count['c']<3)
		  {
			$score=0.00;
		  }
	  }
  }  
}else{
   
  $toidUrlStr="";
  if(get_argp("2id")!=""){
     $msg_touser=intval(get_argp("2id"));
     $mesid=intval(get_argp("mesid"));
	 $sql="update $t_msg_inbox set readed='2',  where mess_id=$mesid";
     $dbo ->exeUpdate($sql);
     $toidUrlStr="&2id=".$msg_touser;
     if(get_argp("nw")!=""){$toidUrlStr=$toidUrlStr."&nw=1";}//判断是否为新窗口
  }

  if(empty($msg_touser)&&get_argp("newsType")!="")
  {
	  $users_row=$dbo->getRow("select user_id,user_name,user_ico from wy_users where user_name='".get_argp("newsType")."'");
  }
  else
  {
	  $users_row = api_proxy("user_self_by_uid","user_id,user_name,user_ico",$msg_touser);
  }

  if($users_row){
	  $touser_id=$users_row[0];
	  $touser=$users_row[1];
	  $touser_ico=$users_row[2];
	  if($touser_id==$user_id)
	  {
		  action_return(0,$m_langpackage->m_no_mys,"modules.php?app=msg_creator".$toidUrlStr);
	  }
  }else{
		action_return(0,$m_langpackage->m_one_err,"modules.php?app=msg_creator".$toidUrlStr);
  }


  if(($user_self['golds']-$score)>=0)
  {
	  $ordernumber='S-P'.time().mt_rand(100,999);
	  $sql="insert into wy_balance set type='3',uid='$user_id',uname='$user_name',touid='$touser_id',touname='$touser',message='站内信费用:".$score."',state='2',addtime=now(),funds='$score',ordernumber='$ordernumber'";
	  $dbo->exeUpdate($sql);

	  //更新用户的积分
	  $sql="update wy_users set golds=golds-$score where user_id=$user_id";
	  $dbo->exeUpdate($sql);
  }
  else
  {
	  action_return(0,$m_langpackage->m_cread_put,"modules.php?app=user_pay");
  }
  
  /*$dbo = new dbex;
  //读写分离定义函数
  dbtarget('w',$dbServs);*/
  
  $img="";
  if (!empty($_FILES["mypictures"]["name"])) { //提取文件域内容名称，并判断
		$path=$webRoot."uploadfiles/myscript/";
		//上传路径
		if(!file_exists($path))
		{
			//检查是否有该文件夹，如果没有就创建，并给予最高权限
			mkdir($path, 0777);
		}
		//允许上传的文件格式
		$tp = array("image/gif","image/pjpeg","image/jpeg");
		//检查上传文件是否在允许上传的类型
		if(!in_array($_FILES["mypictures"]["type"],$tp))
		{
			echo "<script>alert('格式不对');history.go(-1);</script>";
			exit;
		}//END IF
		$filetype = $_FILES['mypictures']['type'];
		if($filetype == 'image/jpeg'){
			$type = '.jpg';
		}
		if ($filetype == 'image/jpg') {
			$type = '.jpg';
		}
		if ($filetype == 'image/pjpeg') {
			$type = '.jpg';
		}
		if($filetype == 'image/gif'){
			$type = '.gif';
		}
		if($_FILES["mypictures"]["name"])
		{
			$today=date("YmdHis"); //获取时间并赋值给变量
			$file2 = $path.$today.$type; //图片的完整路径
			$img = $today.$type; //图片名称
			$flag=1;
		}
		if($flag)
		{
			$result=move_uploaded_file($_FILES["mypictures"]["tmp_name"],$file2);
		}

		$widths=getimagesize($file2);
		if($widths[0]>300)
		{
			$width=' width="300"';
		}
		else
		{
			$width='';
		}

		if(empty($width))
		{
			if($widths[1]>300)
			{
				$height=' height="300"';
			}
			else
			{
				$height='';
			}
		}

		$img='<br/><img src="uploadfiles/myscript/'.$img.'"'.$width.$height.' />';
	}

	$sql="insert into $t_msg_outbox (mess_title,mess_content,to_user_id,to_user,to_user_ico,user_id,add_time,state,mess_acc) value('$msg_title','$msg_txt',$touser_id,'$touser','$touser_ico',$user_id,'".constant('NOWTIME')."','1','$img')";
	if(!$dbo ->exeUpdate($sql)){
		action_return(0,$m_langpackage->m_data_err,"-1");exit;
	}

	if($transtype==0)
	{
		$sql="insert into $t_msg_inbox (mess_title,mess_content,from_user_id,from_user,from_user_ico,user_id,add_time,mesinit_id,transtype,transtate,enmess_title,enmess_content,mess_acc) value('$msg_title','$msg_txt',$user_id,'$user_name','$user_ico',$touser_id,'".constant('NOWTIME')."',LAST_INSERT_ID(),'0','1','$msg_title','$msg_txt','$img')";
	}
	else if($transtype==1)
	{
		$g = new Google_API_translator();
		$g->setText($msg_title,'auto','en');
		$g->translate();
		$msg_title2=$g->out;
		$msg_title2=empty($msg_title2)?$msg_title:$msg_title2;
		
		$g->setText($msg_txt,'auto','en');
		$g->translate();
		$msg_txt2=$g->out;
		$msg_txt2=empty($msg_txt2)?$msg_txt:$msg_txt2;

		$g->setText($msg_title,'auto','zh-CN');
		$g->translate();
		$msg_title3=$g->out;
		$msg_title3=empty($msg_title3)?$msg_title:$msg_title3;
		
		$g->setText($msg_txt,'auto','zh-CN');
		$g->translate();
		$msg_txt3=$g->out;
		$msg_txt3=empty($msg_txt3)?$msg_txt:$msg_txt3;

		$sql="insert into $t_msg_inbox (mess_title,mess_content,from_user_id,from_user,from_user_ico,user_id,add_time,mesinit_id,transtype,transtate,enmess_title,enmess_content,mess_acc) value('$msg_title3','$msg_txt3',$user_id,'$user_name','$user_ico',$touser_id,'".constant('NOWTIME')."',LAST_INSERT_ID(),'1','1','$msg_title2','$msg_txt2','$img')";
	}
	else if($transtype==2)
	{
		$sql="insert into $t_msg_inbox (mess_title,mess_content,from_user_id,from_user,from_user_ico,user_id,add_time,mesinit_id,transtype,transtate,enmess_title,enmess_content,mess_acc) value('$msg_title','$msg_txt',$user_id,'$user_name','$user_ico',$touser_id,'".constant('NOWTIME')."',LAST_INSERT_ID(),'2','0','','','$img')";
	}
	else
	{
		$sql="insert into $t_msg_inbox (mess_title,mess_content,from_user_id,from_user,from_user_ico,user_id,add_time,mesinit_id,transtype,transtate,enmess_title,enmess_content,mess_acc) value('$msg_title','$msg_txt',$user_id,'$user_name','$user_ico',$touser_id,'".constant('NOWTIME')."',LAST_INSERT_ID(),'0','1','$msg_title','$msg_txt','$img')";
	}

	if($dbo ->exeUpdate($sql)){

		//$sql="update $t_msg_inbox set mess_content=concat(mess_content,'','$img'),enmess_content=concat(enmess_content,'','$img') where mess_id=".mysql_insert_id();
	    //$dbo ->exeUpdate($sql);

		api_proxy("message_set",$touser_id,$m_langpackage->m_remind,"modules.php?app=msg_minbox",0,5,"remind");
		if(get_argp('nw')=="2"){
			action_return(1,'',"modules.php?app=msg_moutbox".$toidUrlStr);
		}else{
			action_return(1,'',"modules.php?app=msg_moutbox".$toidUrlStr);
		}
	}else{
	   $sql="update $t_msg_outbox set state='0' where mess_id=LAST_INSERT_ID()";
	   $dbo ->exeUpdate($sql);
	   action_return(0,$m_langpackage->m_send_err,"-1");
	}

}
  /*if(strlen($msg_txt) >=500){
		action_return(0,$m_langpackage->m_add_exc,-1);exit;
  }*/

  $toidUrlStr="";
  if(get_argp("2id")!=""){
     $msg_touser=intval(get_argp("2id"));
     $mesid=intval(get_argp("mesid"));
	 $sql="update $t_msg_inbox set readed='2' where mess_id=$mesid";
     $dbo ->exeUpdate($sql);
     $toidUrlStr="&2id=".$msg_touser;
     if(get_argp("nw")!=""){$toidUrlStr=$toidUrlStr."&nw=1";}//判断是否为新窗口
  }

  if(empty($msg_touser)&&get_argp("newsType")!="")
  {
	  $users_row=$dbo->getRow("select user_id,user_name,user_ico from wy_users where user_name='".get_argp("newsType")."'");
  }
  else
  {
	  $users_row = api_proxy("user_self_by_uid","user_id,user_name,user_ico",$msg_touser);
  }

  if($users_row){
	  $touser_id=$users_row[0];
	  $touser=$users_row[1];
	  $touser_ico=$users_row[2];
	  if($touser_id==$user_id)
	  {
		  action_return(0,$m_langpackage->m_no_mys,"modules.php?app=msg_creator".$toidUrlStr);
	  }
  }else{
		action_return(0,$m_langpackage->m_one_err,"modules.php?app=msg_creator".$toidUrlStr);
  }


  if(($user_self['golds']-$score)>=0)
  {
	  $ordernumber='S-P'.time().mt_rand(100,999);
	  $sql="insert into wy_balance set type='3',uid='$user_id',uname='$user_name',touid='$touser_id',touname='$touser',message='站内信费用:".$score."',state='2',addtime=now(),funds='$score',ordernumber='$ordernumber'";
	  $dbo->exeUpdate($sql);

	  //更新用户的积分
	  $sql="update wy_users set golds=golds-$score where user_id=$user_id";
	  $dbo->exeUpdate($sql);
  }
  else
  {
	  action_return(0,$m_langpackage->m_cread_put,"modules.php?app=user_pay");
  }
  
  /*$dbo = new dbex;
  //读写分离定义函数
  dbtarget('w',$dbServs);*/
  
  $img="";
  if (!empty($_FILES["mypictures"]["name"])) { //提取文件域内容名称，并判断
		$path=$webRoot."uploadfiles/myscript/";
		//上传路径
		if(!file_exists($path))
		{
			//检查是否有该文件夹，如果没有就创建，并给予最高权限
			mkdir($path, 0700);
		}
		//允许上传的文件格式
		$tp = array("image/gif","image/pjpeg","image/jpeg");
		//检查上传文件是否在允许上传的类型
		if(!in_array($_FILES["mypictures"]["type"],$tp))
		{
			echo "<script>alert('格式不对');history.go(-1);</script>";
			exit;
		}//END IF
		$filetype = $_FILES['mypictures']['type'];
		if($filetype == 'image/jpeg'){
			$type = '.jpg';
		}
		if ($filetype == 'image/jpg') {
			$type = '.jpg';
		}
		if ($filetype == 'image/pjpeg') {
			$type = '.jpg';
		}
		if($filetype == 'image/gif'){
			$type = '.gif';
		}
		if($_FILES["mypictures"]["name"])
		{
			$today=date("YmdHis"); //获取时间并赋值给变量
			$file2 = $path.$today.$type; //图片的完整路径
			$img = $today.$type; //图片名称
			$flag=1;
		}
		if($flag)
		{
			$result=move_uploaded_file($_FILES["mypictures"]["tmp_name"],$file2);
		}

		$widths=getimagesize($file2);
		if($widths[0]>300)
		{
			$width=' width="300"';
		}
		else
		{
			$width='';
		}

		if(empty($width))
		{
			if($widths[1]>300)
			{
				$height=' height="300"';
			}
			else
			{
				$height='';
			}
		}

		$img='<br/><img src="uploadfiles/myscript/'.$img.'"'.$width.$height.' />';
	}

	$sql="insert into $t_msg_outbox (mess_title,mess_content,to_user_id,to_user,to_user_ico,user_id,add_time,state,mess_acc) value('$msg_title','$msg_txt',$touser_id,'$touser','$touser_ico',$user_id,'".constant('NOWTIME')."','1','$img')";
	if(!$dbo ->exeUpdate($sql)){
		action_return(0,$m_langpackage->m_data_err,"-1");exit;
	}

	if($transtype==0)
	{
		$sql="insert into $t_msg_inbox (mess_title,mess_content,from_user_id,from_user,from_user_ico,user_id,add_time,mesinit_id,transtype,transtate,enmess_title,enmess_content,mess_acc) value('$msg_title','$msg_txt',$user_id,'$user_name','$user_ico',$touser_id,'".constant('NOWTIME')."',LAST_INSERT_ID(),'0','1','$msg_title','$msg_txt','$img')";
	}
	else if($transtype==1)
	{
		$g = new Google_API_translator();
		$g->setText($msg_title,'auto','en');
		$g->translate();
		$msg_title2=$g->out;
		$msg_title2=empty($msg_title2)?$msg_title:$msg_title2;
		
		$g->setText($msg_txt,'auto','en');
		$g->translate();
		$msg_txt2=$g->out;
		$msg_txt2=empty($msg_txt2)?$msg_txt:$msg_txt2;

		$g->setText($msg_title,'auto','zh-CN');
		$g->translate();
		$msg_title3=$g->out;
		$msg_title3=empty($msg_title3)?$msg_title:$msg_title3;
		
		$g->setText($msg_txt,'auto','zh-CN');
		$g->translate();
		$msg_txt3=$g->out;
		$msg_txt3=empty($msg_txt3)?$msg_txt:$msg_txt3;

		$sql="insert into $t_msg_inbox (mess_title,mess_content,from_user_id,from_user,from_user_ico,user_id,add_time,mesinit_id,transtype,transtate,enmess_title,enmess_content,mess_acc) value('$msg_title3','$msg_txt3',$user_id,'$user_name','$user_ico',$touser_id,'".constant('NOWTIME')."',LAST_INSERT_ID(),'1','1','$msg_title2','$msg_txt2','$img')";
	}
	else if($transtype==2)
	{
		$sql="insert into $t_msg_inbox (mess_title,mess_content,from_user_id,from_user,from_user_ico,user_id,add_time,mesinit_id,transtype,transtate,enmess_title,enmess_content,mess_acc) value('$msg_title','$msg_txt',$user_id,'$user_name','$user_ico',$touser_id,'".constant('NOWTIME')."',LAST_INSERT_ID(),'2','0','','','$img')";
	}
	else
	{
		$sql="insert into $t_msg_inbox (mess_title,mess_content,from_user_id,from_user,from_user_ico,user_id,add_time,mesinit_id,transtype,transtate,enmess_title,enmess_content,mess_acc) value('$msg_title','$msg_txt',$user_id,'$user_name','$user_ico',$touser_id,'".constant('NOWTIME')."',LAST_INSERT_ID(),'0','1','$msg_title','$msg_txt','$img')";
	}

	if($dbo ->exeUpdate($sql)){

		//$sql="update $t_msg_inbox set mess_content=concat(mess_content,'','$img'),enmess_content=concat(enmess_content,'','$img') where mess_id=".mysql_insert_id();
	    //$dbo ->exeUpdate($sql);

		api_proxy("message_set",$touser_id,$m_langpackage->m_remind,"modules.php?app=msg_minbox",0,5,"remind");
		if(get_argp('nw')=="2"){
			action_return(1,'',"modules.php?app=msg_moutbox".$toidUrlStr);
		}else{
			action_return(1,'',"modules.php?app=msg_moutbox".$toidUrlStr);
		}
	}else{
	   $sql="update $t_msg_outbox set state='0' where mess_id=LAST_INSERT_ID()";
	   $dbo ->exeUpdate($sql);
	   action_return(0,$m_langpackage->m_send_err,"-1");
	}
?>

