<?php
	require("api/base_support.php");


   $t_sign=$tablePreStr."sign";
	/*
	$msg_inbox_rs=api_proxy("scrip_inbox_get_mine","count(*)","",0);
	if(is_array($msg_inbox_rs[0]))
	{
		$msg_inbox_rs=$msg_inbox_rs[0][0];
	}
	else
	{
		$msg_inbox_rs=0;
	}

	$msg_notice_rs=api_proxy("scrip_notice_get","count(*)","","and readed='0'");
	if(is_array($msg_notice_rs[0]))
	{
		$msg_notice_rs=$msg_notice_rs[0][0];
	}
	else
	{
		$msg_notice_rs=0;
	}
	*/
	$user_id=get_sess_userid();
	$userinfo=Api_Proxy("user_self_by_uid","*",$user_id);
	if($userinfo['user_group']=='base'||empty($userinfo['user_group']))
	{
		$mtype='<img width="35" height="35" src="skin/'.$skinUrl.'/images/xin/01.gif"/>&nbsp;';
	}
	else
	{
		$mtype='<img width="35" height="35" src="skin/'.$skinUrl.'/images/xin/0'.$userinfo['user_group'].'.gif"/>&nbsp;';
	}
	
	//创建系统对数据库进行操作的对象
	$dbo=new dbex();
	//对数据进行读写分离，读操作
	dbplugin('r');
	//查询用户的礼品
	$sql="select count(*) from gift_order where is_see='0' and accept_id=".get_sess_userid();
	$gifts=$dbo->getRow($sql);
	if(is_array($gifts))
	{
		$gifts=$gifts[0];
	}
	else
	{
		$gifts=0;
	}
    //商城礼物
	$gift_list=$dbo->getRs("select id,yuanpatch,patch,giftname from gift_news order by id limit 0,4");
    //print_r($gift_list);

	$dbo=new dbex();
	//定义读操作
	dbtarget('r',$dbServs);
    //是否签到
    $sql = "select user_id,user_name,sign_flag,sign_addtime from $t_sign where user_id=$user_id order by sign_addtime desc";


      $flag=$dbo->getRow($sql);

      $stime = $flag['sign_addtime'];
       
     //echo $tmp=date('Y-m-d H:i:s',$stime);


     //echo $tmp;exit;
    $stmp = time()-$stime;
    if($flag['sign_flag']==1 && $stmp <24*60*60 ){
        $sflag=1;
    }else{
        $sflag=0;
    }
    
    //  签到列表

    $sql = "select sign_id,user_id,user_name,sign_flag,sign_addtime,user_ico from $t_sign where sign_flag=1 group by user_id order by sign_addtime desc  limit 5";
    $flaglist=$dbo->getRs($sql);
    //print_r($flaglist);exit;
    //未读邮件数量
    

    
?>