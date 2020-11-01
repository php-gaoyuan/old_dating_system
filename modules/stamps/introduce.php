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
<body onload="parent.get_mess_count();">
<div class="tabs" style="border:1px solid #ce1221;text-align:left;padding-left:15px;padding-top:5px;">
    <?php echo $info;?>
</div>
<div class="tabs">
    <ul class="menu">
        <li><a href="modules2.0.php?app=user_pay" hidefocus="true"><?php echo $er_langpackage->er_recharge;?></a></li>
        <li><a href="modules2.0.php?app=user_paylog" hidefocus="true"><?php echo $er_langpackage->er_recharge_log;?></a></li>
        <li><a href="modules2.0.php?app=user_consumption" hidefocus="true"><?php echo $er_langpackage->er_consumption_log;?></a></li>
        <li><a href="modules2.0.php?app=user_upgrade" hidefocus="true"><?php echo $er_langpackage->er_upgrade;?></a></li>
        <li class="active"><a href="modules2.0.php?app=user_introduce" hidefocus="true"><?php echo $er_langpackage->er_introduce;?></a></li>
        <li><a href="modules2.0.php?app=user_help" hidefocus="true"><?php echo $er_langpackage->er_help;?></a></li>
    </ul>
</div>
<div class="feedcontainer">
<?php if($langPackagePara=='en'){?>
<table width="550" border="0" cellspacing="0" cellpadding="0" style="font-size: 12px;color: #666;line-height:20px;">
  <tr>
    <td height="30" style="color:#555; font-weight:bold;">User identity that ：</td>
  </tr>
</table>
<table width="550" border="0" cellpadding="0" cellspacing="1" bgcolor="#EECAF0" style="font-size: 12px;color: #666;line-height:20px;">
  <tr>
    <td width="78" height="30" align="center" bgcolor="#FAE4FA"><b>identity </b></td>
    <td width="51" align="center" bgcolor="#FAE4FA"><b>mark </b></td>
    <td width="417" align="center" bgcolor="#FAE4FA"><b>introduction</b></td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">Ordinary members</td>
    <td align="center" bgcolor="#FFFDFF">&nbsp;</td>
    <td bgcolor="#FFFDFF" style="padding:10px;">Free use of the site function, every day can appropriate contact with other users, interactive</td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">VIP member </td>
    <td align="center" bgcolor="#FFFDFF"><img src="skin/<?php echo $skinUrl;?>/images/xin/01.gif" width="19" height="17" /></td>
    <td bgcolor="#FFFDFF" style="padding:10px;">Can use the site most function, every day can be any contact with other users, making friends, interactive </td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">Diamond VIP member </td>
    <td align="center" bgcolor="#FFFDFF"><img src="skin/<?php echo $skinUrl;?>/images/xin/02.gif" width="19" height="17" /></td>
    <td bgcolor="#FFFDFF" style="padding:10px;">Can use most of the website function, not only can every day with any user contact, making friends, interactive, still can enjoy the artificial translation, such as high speed upgrade and privilege 
    </td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">Purple drill VIP member</td>
    <td align="center" bgcolor="#FFFDFF"><img src="skin/<?php echo $skinUrl;?>/images/xin/03.gif" width="19" height="17" /></td>
    <td bgcolor="#FFFDFF" style="padding:10px;">Can use all of the functions of website, not only can every day with any user contact, making friends, interactive, still can enjoy the artificial translation, such as high speed upgrade and privilege</td>
  </tr>
</table>
<br />
<table width="550" border="0" cellspacing="0" cellpadding="0" style="font-size: 12px;color: #666;line-height:20px;">
  <tr>
    <td height="30" style="color:#555; font-weight:bold;">User identity that：</td>
  </tr>
</table>
<table width="550" border="0" cellpadding="0" cellspacing="1" bgcolor="#EECAF0" style="font-size: 12px;color: #666;line-height:20px;">
  <tr>
    <td bgcolor="#FFFDFF" style="padding:10px;">Online level by the user login zealdate active hours decision, you need to login zealdate, can accumulate active hours online access level. <br />
      Zealdate online level by three labeled graph display, from low to high respectively for the stars, the moon and the sun.  <br />
      <br />
  <strong>Active small "calculation rules </strong><br />
      Ordinary users: use zealdate one hour, active hours accumulated 1. (half an hour meter 0.5, below half an hour, not cumulative)  <br />
      VIP user: use zealdate one hour, active accumulated 1.2 hours.  <br />
      Diamond VIP user: use zealdate one hour, active accumulated 1.5 hours.  <br />
    Purple drill VIP user: use zealdate one hour, active hours accumulated 2. 
    <br />
    <br />
    Zealdate upgrade corresponding active day meter, the user's zealdate level is divided into three stages, among them, 4 stars = 1 the moon, the moon and the sun = 1. <br />
    If a user level for N, the level conversion into active hours h: h = N3 </td>
  </tr>
</table>
<br />
<table width="550" border="0" cellpadding="0" cellspacing="1" bgcolor="#EECAF0" style="font-size: 12px;color: #666;line-height:20px;">
  <tr>
    <td width="85" height="30" align="center" bgcolor="#FAE4FA"><b>Function and privilege</b></td>
    <td width="65" align="center" bgcolor="#FAE4FA"><b>Level icon</b></td>
    <td width="65" align="center" bgcolor="#FAE4FA"><b>Related identity </b></td>
    <td width="330" align="center" bgcolor="#FAE4FA"><b>that</b></td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">rechargeable  </td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="330" bgcolor="#FFFDFF" style="padding:10px;">Buy purple money for yourself or friends, used to exchange senior status or function </td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">album </td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="330" bgcolor="#FFFDFF" style="padding:10px;">Ordinary users can upload 10 images, the VIP user 30 zhang, diamond VIP100 zhang. Purple drill VIP no limit. </td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">log </td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="330" bgcolor="#FFFDFF" style="padding:10px;">Ordinary users may be published every day 1 journal, the VIP customers in three, diamond VIP10 article. Purple drill VIP no limit. </td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">mailbox </td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="330" bgcolor="#FFFDFF" style="padding:10px;">Ordinary users can every day published L mail, any VIP. Diamond VIP a day can free use fifty sealing artificial translation, purple drill VIP a day can free use 100 seal artificial translation. </td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">gift </td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="330" bgcolor="#FFFDFF" style="padding:10px;">Diamond VIP and purple drill VIP can send free zealdate senior gift </td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">group </td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="65" align="center" bgcolor="#FFFDFF">16</td>
    <td width="330" bgcolor="#FFFDFF" style="padding:10px;">VIP above level can build more group. Ordinary users to 16 level can be free to build a group </td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">share</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="330" bgcolor="#FFFDFF" style="padding:10px;">Friends share the new situation </td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">Message board </td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="330" bgcolor="#FFFDFF" style="padding:10px;">In the space of friends to show you want to say </td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">decoration </td>
    <td width="65" align="center" bgcolor="#FFFDFF"><p align="center">&nbsp;</p></td>
    <td width="65" align="center" bgcolor="#FFFDFF">4</td>
    <td width="330" bgcolor="#FFFDFF" style="padding:10px;">VIP above level or online to 16 level can be arbitrary change space skin </td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">promotion </td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="330" bgcolor="#FFFDFF" style="padding:10px;">Invite your friends to zealdate right, each invited one, will get 1 purple COINS and ten points </td>
  </tr>
</table>
<?php }else{ ?>
<table width="550" border="0" cellspacing="0" cellpadding="0" style="font-size: 12px;color: #666;line-height:20px;">
  <tr>
    <td height="30" style="color:#555; font-weight:bold;">用户身份说明：</td>
  </tr>
</table>
<table width="550" border="0" cellpadding="0" cellspacing="1" bgcolor="#EECAF0" style="font-size: 12px;color: #666;line-height:20px;">
  <tr>
    <td width="78" height="30" align="center" bgcolor="#FAE4FA"><b>身份</b></td>
    <td width="51" align="center" bgcolor="#FAE4FA"><b>标志</b></td>
    <td width="417" align="center" bgcolor="#FAE4FA"><b>简介</b></td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">普通会员</td>
    <td align="center" bgcolor="#FFFDFF">&nbsp;</td>
    <td bgcolor="#FFFDFF" style="padding:10px;">免费使用网站的部分功能，每天可以适当的与其他用户联系、互动</td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">VIP会员</td>
    <td align="center" bgcolor="#FFFDFF"><img src="skin/<?php echo $skinUrl;?>/images/xin/01.gif" width="19" height="17" /></td>
    <td bgcolor="#FFFDFF" style="padding:10px;">可以使用网站的多数功能，每天可以任意与其他用户联系、交友、互动</td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">钻石VIP会员</td>
    <td align="center" bgcolor="#FFFDFF"><img src="skin/<?php echo $skinUrl;?>/images/xin/02.gif" width="19" height="17" /></td>
    <td bgcolor="#FFFDFF" style="padding:10px;">可以使用网站的大多功能，每天不单可以与任意用户联系、交友、互动，还可以享有人工翻译、高速升级等尊贵特权
    </td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">紫钻VIP会员</td>
    <td align="center" bgcolor="#FFFDFF"><img src="skin/<?php echo $skinUrl;?>/images/xin/03.gif" width="19" height="17" /></td>
    <td bgcolor="#FFFDFF" style="padding:10px;">可以使用网站的全部功能，每天不单可以与任意用户联系、交友、互动，还可以享有人工翻译、高速升级等尊贵特权</td>
  </tr>
</table>
<br />
<table width="550" border="0" cellspacing="0" cellpadding="0" style="font-size: 12px;color: #666;line-height:20px;">
  <tr>
    <td height="30" style="color:#555; font-weight:bold;">用户身份说明：</td>
  </tr>
</table>
<table width="550" border="0" cellpadding="0" cellspacing="1" bgcolor="#EECAF0" style="font-size: 12px;color: #666;line-height:20px;">
  <tr>
    <td bgcolor="#FFFDFF" style="padding:10px;">在线等级由用户登录zealdate的活跃小时数决定，您只需登录zealdate，即可累积活跃小时数获取在线等级。<br />
      zealdate在线等级由三个标示图展示，从低到高分别为星星、月亮、太阳。 <br />
      <br />
  <strong>“活跃小”计算规则</strong><br />
      普通用户：使用zealdate一小时，活跃小时数累积1。（半小时计0.5，半小时以下的，不累积） <br />
      VIP用户：使用zealdate一小时，活跃小时数累积1.2。 <br />
      钻石VIP用户：使用zealdate一小时，活跃小时数累积1.5。 <br />
    紫钻VIP用户：使用zealdate一小时，活跃小时数累积2。
    <br />
    <br />
    zealdate等级升级对应活跃天数表，用户的zealdate等级分为三大阶段，其中，4星星=1月亮，4月亮=1太阳。<br />
    假设用户的等级为N，则等级换算成活跃小时数h为：h=N3</td>
  </tr>
</table>
<br />
<table width="550" border="0" cellpadding="0" cellspacing="1" bgcolor="#EECAF0" style="font-size: 12px;color: #666;line-height:20px;">
  <tr>
    <td width="85" height="30" align="center" bgcolor="#FAE4FA"><b>功能和特权</b></td>
    <td width="65" align="center" bgcolor="#FAE4FA"><b>等级图标</b></td>
    <td width="65" align="center" bgcolor="#FAE4FA"><b>相关身份</b></td>
    <td width="330" align="center" bgcolor="#FAE4FA"><b>说明</b></td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">充值 </td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="330" bgcolor="#FFFDFF" style="padding:10px;">购买紫币给自己或朋友，用来兑换高级身份或功能</td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">相册</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="330" bgcolor="#FFFDFF" style="padding:10px;">普通用户可以上传10张图片，VIP用户30张，钻石VIP100张。紫钻VIP没有限制。</td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">日志</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="330" bgcolor="#FFFDFF" style="padding:10px;">普通用户每天可以发表1篇日志，VIP用户3篇，钻石VIP10篇。紫钻VIP没有限制。</td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">邮箱</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="330" bgcolor="#FFFDFF" style="padding:10px;">普通用户每天可以发表L邮件， VIP不限。钻石VIP每天可以免费使用50封人工翻译，紫钻VIP每天可以免费使用100封人工翻译。</td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">礼物</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="330" bgcolor="#FFFDFF" style="padding:10px;">钻石VIP和紫钻VIP可以免费发送zealdate 高级礼物</td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">群组</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="65" align="center" bgcolor="#FFFDFF">16</td>
    <td width="330" bgcolor="#FFFDFF" style="padding:10px;">VIP以上级别可以建多个群。普通用户达到16级可以免费建一个群</td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">分享</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="330" bgcolor="#FFFDFF" style="padding:10px;">分享好友的新情况</td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">留言板</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="330" bgcolor="#FFFDFF" style="padding:10px;">在好友的空间里展示你想说的</td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">装饰</td>
    <td width="65" align="center" bgcolor="#FFFDFF"><p align="center">&nbsp;</p></td>
    <td width="65" align="center" bgcolor="#FFFDFF">4</td>
    <td width="330" bgcolor="#FFFDFF" style="padding:10px;">VIP以上级别或者在线达到16级可以任意更换空间皮肤</td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#FFFDFF">推广</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="65" align="center" bgcolor="#FFFDFF">all</td>
    <td width="330" bgcolor="#FFFDFF" style="padding:10px;">邀请你的朋友来zealdate吧，每邀请一个，将得到1紫币和10积分</td>
  </tr>
</table>
<?php }?>
</div>
</body>