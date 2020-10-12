<?php
	//引入公共模块
	require("foundation/module_event.php");
	require("api/base_support.php");
	
	//引入语言包
	$er_langpackage=new rechargelp;
	$dopost="savesend";
	
	//必须登录才能浏览该页面
	require("foundation/auser_mustlogin.php");
	
	$user_id=get_sess_userid();
	//限制时间段访问站点
	limit_time($limit_action_time);

	$friends=Api_Proxy("pals_self_by_paid","pals_name,pals_id,pals_ico");

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