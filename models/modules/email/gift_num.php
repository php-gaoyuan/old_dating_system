<?php
	//引入模块公共权限过程文件
require("foundation/auser_mustlogin.php");
require("foundation/module_users.php");
require("foundation/fplugin.php");
require("api/base_support.php");
require("foundation/fdnurl_aget.php");
require("foundation/fgrade.php");
	require("foundation/fpages_bar.php");
	require("api/base_support.php");
	//引入语言包
	$m_langpackage=new msglp;
	$user_id=get_sess_userid();
	$dbo = new dbex;
	dbtarget('r',$dbServs);
    //未读邮件数量
	$sql="select count(*) as num from gift_order where  accept_id=$user_id";
    $giftnum = $dbo->getRow($sql);
	if($giftnum){
		echo $giftnum['num'];
	}else{
		echo 0;
	}
	
?>