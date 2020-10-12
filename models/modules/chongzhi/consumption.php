<?php
	//引入公共模块
	require("foundation/module_event.php");
	require("foundation/fpages_bar.php");
	require("api/base_support.php");
	
	//引入语言包
	$er_langpackage=new rechargelp;
	$dopost="savesend";
	
	//必须登录才能浏览该页面
	require("foundation/auser_mustlogin.php");
	
	$user_id=get_sess_userid();
	$page_num=trim(get_argg('page'));

	$dbo=new dbex;
	dbplugin('r');

	$sql="select * from wy_balance where type!='1' and  type!='3' and state='2' and uid='$user_id' order by id desc";

	$dbo->setPages(10,$page_num);//设置分页
	$mp_list_rs=$dbo->getRs($sql);
	$page_total=$dbo->totalPage;//分页总数
	//print_r($mp_list_rs);
	$none_data="content_none";
	$isNull=0;
	if(empty($mp_list_rs)){
		$none_data="";
		$isNull=1;
	}

	function getstate($state)
	{
		global $er_langpackage;
		if($state==2)
			return $er_langpackage->er_good;
	}

	function gettypes($type)
	{
		global $er_langpackage;
		if($type==2)
			return $er_langpackage->er_updage;
		else if($type==3)
			return $er_langpackage->er_putmsg;
		else if($type==4)
			return $er_langpackage->er_gift;
	}

	$userinfo=Api_Proxy("user_self_by_uid","*",$user_id);
	$info="<font color='#ce1221' style='font-weight:bold;'>".$er_langpackage->er_currency."</font>：".$userinfo['golds'];

	if(!empty($userinfo['user_group'])&&$userinfo['user_group']!='base')
	{
		$groups=$dbo->getRow("select * from wy_frontgroup where gid='$userinfo[user_group]'");

		if($langPackagePara=='en')
		{
			$groups['name']=str_replace('普通会员','VIP member',$groups['name']);
			$groups['name']=str_replace('高级会员','Silver member',$groups['name']);
			$groups['name']=str_replace('星级会员','Star Member',$groups['name']);
		}
		$info.="&nbsp;&nbsp;&nbsp;&nbsp;".$er_langpackage->er_nowtype."：".$groups['name'];

		$groups=$dbo->getRow("select * from wy_upgrade_log where mid='$user_id' and state='0' order by id desc limit 1");
		$startdate=strtotime(date("Y-m-d"));
		$enddate=strtotime($groups['endtime']);
		$days=round(($enddate-$startdate)/3600/24);
		$info.="&nbsp;&nbsp;&nbsp;&nbsp;".$er_langpackage->er_howtime."：".$days.$er_langpackage->er_day;
	}
?>