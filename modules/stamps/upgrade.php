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

	if(!empty($userinfo['user_group'])&&$userinfo['user_group']!='1')
	{
		$groups=$dbo->getRow("select * from wy_frontgroup where gid='$userinfo[user_group]'");

		if($langPackagePara=='en')
		{
			$groups['name']=str_replace('VIP会员','VIP member',$groups['name']);
			$groups['name']=str_replace('钻石会员','diamond member',$groups['name']);
			$groups['name']=str_replace('紫钻会员','Purple drill member',$groups['name']);
		}
		$info.="&nbsp;&nbsp;&nbsp;&nbsp;".$er_langpackage->er_nowtype."：".$groups['name'];

		$groups=$dbo->getRow("select * from wy_upgrade_log where mid='$user_id' and state='0' order by id desc limit 1");
		$startdate=strtotime(date("Y-m-d"));
		$enddate=strtotime($groups['endtime']);
		$days=round(($enddate-$startdate)/3600/24);
		$info.="&nbsp;&nbsp;&nbsp;&nbsp;".$er_langpackage->er_howtime."：".$days.$er_langpackage->er_day;
	}
?><link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css" />
<script language=JavaScript src="skin/default/js/jooyea.js"></script>
<SCRIPT language=JavaScript src="servtools/ajax_client/ajax.js"></SCRIPT>
<script type="text/javascript" language="javascript" src="servtools/dialog/zDrag.js"></script>
<script type="text/javascript" language="javascript" src="servtools/dialog/zDialog.js"></script>
<script>
function check(obj)
{
	var check=new Ajax();
	check.getInfo("do.php","get","app","act=reg&ajax=1&user_name="+obj,function(c){if(!c){Dialog.alert('<?php echo $er_langpackage->er_Dos_notex;?>');}});
}

function supert(obj)
{
	if(obj><?php echo $userinfo['golds'];?>)
	{
		Dialog.confirm('<?php echo $er_langpackage->er_mess;?>'+<?php echo $userinfo['golds'];?>+'<?php echo $er_langpackage->er_mess2;?>',function (){location='modules2.0.php?app=user_pay';});
	}
}
</script>
<body onload="parent.get_mess_count();">
<div class="tabs" style="border:1px solid #ce1221;text-align:left;padding-left:15px;padding-top:5px;">
    <?php echo $info;?>
</div>
<div class="tabs">
    <ul class="menu">
        <li><a href="modules2.0.php?app=user_pay" hidefocus="true"><?php echo $er_langpackage->er_recharge;?></a></li>
        <li><a href="modules2.0.php?app=user_paylog" hidefocus="true"><?php echo $er_langpackage->er_recharge_log;?></a></li>
        <li><a href="modules2.0.php?app=user_consumption" hidefocus="true"><?php echo $er_langpackage->er_consumption_log;?></a></li>
        <li class="active"><a href="modules2.0.php?app=user_upgrade" hidefocus="true"><?php echo $er_langpackage->er_upgrade;?></a></li>
        <li><a href="modules2.0.php?app=user_introduce" hidefocus="true"><?php echo $er_langpackage->er_introduce;?></a></li>
        <li><a href="modules2.0.php?app=user_help" hidefocus="true"><?php echo $er_langpackage->er_help;?></a></li>
    </ul>
</div>
<div class="feedcontainer">
	<ul id="sec_Content">
	<form id="pay" name="pay" method="post" action="do.php">
<input name="act" type="hidden" value="upgrade" />
	<li style="height:auto;padding: 19px 15px;text-align:left;">
		<table width="80%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">
			<tr>
				<td style="width:120px;text-align:left;height:30px;"><input type="radio" name="touser" value="1" checked="checked" />：<?php echo $er_langpackage->er_oneself;?></td>
			</tr>
			<tr>
				<td style="text-align:left;height:50px;"><input type="radio" name="touser" value="2" />：
				<?php echo $er_langpackage->er_friends;?>&nbsp;&nbsp;<input type="text" name="friends" id="friends" style="width:80px;height:25px;" onchange="check(value)" />&nbsp;&nbsp;
				<select name="selfriend" id="selfriend" onchange="document.getElementById('friends').value=value;">
				  <option value=""><?php echo $er_langpackage->er_choose_fr;?></option>
				  <?php foreach($friends as $friend){?>
				  <option value="<?php echo $friend['pals_name'];?>"><?php echo $friend['pals_name'];?></option>
				  <?php }?>
				</select>
				</td>
			</tr>
		</table>
	</li>
	<li style="height:auto;padding: 19px 15px;text-align:left;font-weight:bold;">
		<img width="19" height="17" src="skin/<?php echo $skinUrl;?>/images/xin/01.gif" style="vertical-align:middle;"/>&nbsp;<?php echo $er_langpackage->er_gj;?>：
	</li>
	<li style="height:auto;padding: 10px 15px;text-align:left;border-bottom:0px;">
		<input name="zibi" type="radio" value="gj1" onclick="supert(20)" checked="checked" />&nbsp;<?php echo $er_langpackage->er_gj_1y;?>
	</li>
	<li style="height:auto;padding: 10px 15px;text-align:left;border-bottom:0px;">
		<input name="zibi" type="radio" value="gj2" onclick="supert(50)" />&nbsp;<?php echo $er_langpackage->er_gj_3y;?>
	</li>
	<li style="height:auto;padding: 10px 15px;text-align:left;border-bottom:0px;">
		<input name="zibi" type="radio" value="gj3" onclick="supert(80)" />&nbsp;<?php echo $er_langpackage->er_gj_6y;?>
	</li>
	<li style="height:auto;padding: 10px 15px;text-align:left;border-bottom:0px;">		
		<table width="80%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;" >
			<tr>
				<td style="text-align:left;"><input name="zibi" type="radio" value="gj4" onclick="supert(140)" />&nbsp;<?php echo $er_langpackage->er_gj_1n;?></td>
				<td style="text-align:right;"><input type="submit" name="button" id="button" style="background-image:url(/skin/<?php echo $skinUrl;?>/images/xin/an01.jpg);width:104px;height:29px;border:0px;font-weight:bold;color:#FFF;cursor:pointer;" value="<?php echo $er_langpackage->er_goupgrade;?>" /></td>
			</tr>
		</table>		
	</li>
	<li style="height:auto;padding: 19px 15px;text-align:left;font-weight:bold;">
		<img width="19" height="17" src="skin/<?php echo $skinUrl;?>/images/xin/02.gif" style="vertical-align:middle;"/>&nbsp;<?php echo $er_langpackage->er_vip;?>：
	</li>
	<li style="height:auto;padding: 10px 15px;text-align:left;border-bottom:0px;">
		<input name="zibi" type="radio" value="vip1" onclick="supert(180)" />&nbsp;<?php echo $er_langpackage->er_vip_1y;?>
	</li>
	<li style="height:auto;padding: 10px 15px;text-align:left;border-bottom:0px;">
		<input name="zibi" type="radio" value="vip2" onclick="supert(480)" />&nbsp;<?php echo $er_langpackage->er_vip_3y;?>
	</li>
	<li style="height:auto;padding: 10px 15px;text-align:left;border-bottom:0px;">
		<input name="zibi" type="radio" value="vip3" onclick="supert(880)" />&nbsp;<?php echo $er_langpackage->er_vip_6y;?>
	</li>
	<li style="height:auto;padding: 10px 15px;text-align:left;border-bottom:0px;">
		<table width="80%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;" >
			<tr>
				<td style="text-align:left;"><input name="zibi" type="radio" value="vip4" onclick="supert(1280)" />&nbsp;<?php echo $er_langpackage->er_vip_1n;?></td>
				<td style="text-align:right;"><input type="submit" name="button" id="button" style="background-image:url(/skin/<?php echo $skinUrl;?>/images/xin/an01.jpg);width:104px;height:29px;border:0px;font-weight:bold;color:#FFF;cursor:pointer;" value="<?php echo $er_langpackage->er_goupgrade;?>" /></td>
			</tr>
		</table>
	</li>
	<li style="height:auto;padding: 19px 15px;text-align:left;font-weight:bold;">
		<img width="19" height="17" src="skin/<?php echo $skinUrl;?>/images/xin/03.gif" style="vertical-align:middle;"/>&nbsp;<?php echo $er_langpackage->er_zvip;?>：
	</li>
	<li style="height:auto;padding: 10px 15px;text-align:left;border-bottom:0px;">
		<input name="zibi" type="radio" value="zvip1" onclick="supert(280)" />&nbsp;<?php echo $er_langpackage->er_zvip_1y;?>
	</li>
	<li style="height:auto;padding: 10px 15px;text-align:left;border-bottom:0px;">
		<input name="zibi" type="radio" value="zvip2" onclick="supert(680)" />&nbsp;<?php echo $er_langpackage->er_zvip_3y;?>
	</li>
	<li style="height:auto;padding: 10px 15px;text-align:left;border-bottom:0px;">
		<input name="zibi" type="radio" value="zvip3" onclick="supert(1180)" />&nbsp;<?php echo $er_langpackage->er_zvip_6y;?>
	</li>
	<li style="height:auto;padding: 10px 15px;text-align:left;border-bottom:0px;">
		<table width="80%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;" >
			<tr>
				<td style="text-align:left;"><input name="zibi" type="radio" value="zvip4" onclick="supert(1680)" />&nbsp;<?php echo $er_langpackage->er_zvip_1n;?></td>
				<td style="text-align:right;"><input type="submit" name="button" id="button" style="background-image:url(/skin/<?php echo $skinUrl;?>/images/xin/an01.jpg);width:104px;height:29px;border:0px;font-weight:bold;color:#FFF;cursor:pointer;" value="<?php echo $er_langpackage->er_goupgrade;?>" /></td>
			</tr>
		</table>		
	</li>
</form>
</ul>
</div>
</body>