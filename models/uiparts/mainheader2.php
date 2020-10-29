<?php

require("foundation/asession.php");
require("configuration.php");
//require("includes.php");
//必须登录才能浏览该页面


require("foundation/fplugin.php");
require("api/base_support.php");
require("foundation/fdnurl_aget.php");
require("foundation/fgrade.php");
//语言包引入

$u_langpackage=new userslp;
$ef_langpackage=new event_frontlp;
$mn_langpackage=new menulp;
$pu_langpackage=new publiclp;
$mp_langpackage=new mypalslp;
$s_langpackage=new sharelp;
$hi_langpackage=new hilp;
$l_langpackage=new loginlp;
$rp_langpackage=new reportlp;
$ah_langpackage=new arrayhomelp;

$user_id=get_sess_userid();

$user_name=get_sess_username();

$user_info=api_proxy("user_self_by_uid","guest_num,integral,onlinetimecount",$user_id);

$remind_count=api_proxy("message_get_remind_count");
    //好友提示数量
	
	$t_scrip=$tablePreStr."msg_inbox";
	//$result_rs=array();
	
	$dbo=new dbex;
  dbtarget('r',$dbServs);
  
  $sql=" select count(*) as num from $t_scrip where user_id = $user_id and from_user='系统发送' and readed=0";
  //echo $sql;
	//$dbo->setPages(20,$page_num);
	
	$friends_num=$dbo->getRow($sql);
	//$page_total=$dbo->totalPage;
	//return $result_rs;
	
	//echo $friends_num['num'];
	
    $friendnum = $friends_num['num'];
	/*
*/
?>