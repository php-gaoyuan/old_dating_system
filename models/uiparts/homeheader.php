<?php
//语言包引入
$ah_langpackage=new arrayhomelp;

$remind_count=api_proxy("message_get_remind_count");
    //好友提示数量
	$uid=get_sess_userid();
	$t_scrip=$tablePreStr."msg_inbox";
	//$result_rs=array();
	$dbo=new dbex;
  dbplugin('r');
  $sql=" select count(*) as num from $t_scrip where user_id = $uid and from_user='系统发送' and readed=0";
	//$dbo->setPages(20,$page_num);
	$friends_num=$dbo->getRow($sql);
	//$page_total=$dbo->totalPage;
	//return $result_rs;
    $friendnum = $friends_num['num'];

    //echo  $friendnum;
?>