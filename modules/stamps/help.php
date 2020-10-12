<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/stamps/help.html
 * 如果您的模型要进行修改，请修改 models/modules/stamps/help.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
/*
 * 此段代码由debug模式下生成运行，请勿改动！
 * 如果debug模式下出错不能再次自动编译时，请进入后台手动编译！
 */
/* debug模式运行生成代码 开始 */
if(!function_exists("tpl_engine")) {
	require("foundation/ftpl_compile.php");
}
if(filemtime("templates/default/modules/stamps/help.html") > filemtime(__file__) || (file_exists("models/modules/stamps/help.php") && filemtime("models/modules/stamps/help.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/stamps/help.html",1);
	include(__file__);
}else {
/* debug模式运行生成代码 结束 */
?><?php
	//引入公共模块
	require("foundation/module_event.php");
	require("api/base_support.php");
	
	//引入语言包
	$er_langpackage=new rechargelp;
	$s_langpackage=new stampslp;
	$dopost="savesend";
	
	//必须登录才能浏览该页面
	require("foundation/auser_mustlogin.php");
	
	$user_id=get_sess_userid();
	$uname=get_args('uname');

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

	$sumoney=0;
	switch ($userinfo['user_group'])
	{
		/*case 1:
		  $sumoney=200*95/100;
		  break;*/
		case 2:
		  $sumoney=100;
		  break;
		case 3:
		  $sumoney=200;
		  break;
		default:
		  $sumoney=200;
	}
?><link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css" />
<body onload="parent.get_mess_count();">
<div class="tabs" style="border:1px solid #ce1221;text-align:left;padding-left:15px;padding-top:5px;">
    <?php echo $info;?>
</div>
<div class="tabs">
    <ul class="menu">
        <li><a href="modules.php?app=user_stamps" hidefocus="true"><?php echo $s_langpackage->s_change;?></a></li>
        <li><a href="modules.php?app=user_help" hidefocus="true"><?php echo $er_langpackage->er_help;?></a></li>
        <li class="active"><a href="modules.php?app=stamps_help" hidefocus="true"><?php echo $s_langpackage->s_guize;?></a></li>
    </ul>
</div>
<div class="feedcontainer">
<?php if($langPackagePara=='en'){?>
<table width="550" border="1" cellpadding="0" cellspacing="0" bgcolor="#EECAF0" style="font-size: 12px;color: #666;line-height:20px;">
  <tr>
    <td valign="top" bgcolor="#FFFDFF" style="padding:10px;"><strong>1. How do you redeem stamps? </strong><br />
      You can log in – Conversion. We currently only support gold exchange. This website has absolutely no automatic memory or recurring charges procedures. If you have any questions, please contact us immediately.  <br />
      <br />
  <strong>2. How much gold coins does a stamp need? </strong><br />
      A stamp needs about two gold coins.  <br />
      <br />
  <strong>3. How long can be it credited into account after exchange? </strong><br />
      Under normal circumstances, after conversion stamps will be displayed in the left column of the stamps .If you have any questions about the transaction, and then you can submit to us your number and transaction number of goods, so that we can help you check.
<br />
      <br />
  <strong>4.Stamps rules</strong><br />
      In the traditional process of interaction, geese, postal flowers teaser, a small stamp tend to carry a kind of feeling, a kind of love sickness. So loveybible uses stamps to help people express emotions and romantic ways in such a way.<br /> 
	  "loveybible to see the letter tickets," that is, You can see the letter tickets to read the letter with loveybible. (With only a loveybible stamps you can establish permanent contact with a heterosexual). <br/>
     Loveybible stamp purchase rules: The price of a ticket to see the letter is two gold coins. Coins are available directly exchange.
	 <br />
   </td>
  </tr>
</table>
<?php }else{ ?>
<table width="550" border="1" cellpadding="0" cellspacing="0" bgcolor="#EECAF0" style="font-size: 12px;color: #666;line-height:20px;">
  <tr>
    <td valign="top" bgcolor="#FFFDFF" style="padding:10px;"><strong>1. 如何兑换邮票？</strong><br />
      您可以登录-兑换。我们目前仅支持金币兑换。本站绝没有任何自动记忆或重复收费的程序。有任何疑问，请马上与我们联系。 <br />
      <br />
  <strong>2.一张邮票需要多少金币？</strong><br />
      一张邮票大约需要2金币。 <br />
      <br />
  <strong>3.兑换过后多长时间可以到账？</strong><br />
    通常情况下兑换过后邮票就会在左边栏邮票里显示出来的。如果您对交易有疑问的话可以提交给我们您的货品号和交易号，以便我们帮您核查。<br /><br />
 <strong>4.邮票规则</strong><br />
 在传统的交往过程中，鸿雁传书，邮花传情，一枚小小的邮票，往往携带着一种情思，一种相思。Loveybible因此用邮票这样一种方式，帮助大家传情达意，互诉衷肠。<br/>
 “loveybible看信票”即您可用loveybible看信票进行看信（仅需1张loveybible邮票就可以与1位异性建立永久联系）。<br/>
 Loveybible邮票的购买规则是：一张看信票的价格均是2金币。可用金币直接兑换。
    </td>
  </tr>
</table>
<?php }?>
</div>
</body><?php } ?>