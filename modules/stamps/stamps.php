<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/stamps/stamps.html
 * 如果您的模型要进行修改，请修改 models/modules/stamps/stamps.php
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
if(filemtime("templates/default/modules/stamps/stamps.html") > filemtime(__file__) || (file_exists("models/modules/stamps/stamps.php") && filemtime("models/modules/stamps/stamps.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/stamps/stamps.html",1);
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
		  $sumoney=200;
		  break;
		case 3:
		  $sumoney=400;
		  break;
		default:
		  $sumoney=400;
	}
?><link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css" />
<script language=JavaScript src="skin/default/js/jooyea.js"></script>
<SCRIPT language=JavaScript src="servtools/ajax_client/ajax.js"></SCRIPT>
<script type="text/javascript" language="javascript" src="servtools/dialog/zDrag.js"></script>
<script type="text/javascript" language="javascript" src="servtools/dialog/zDialog.js"></script>
<script>
var zkk=0;
function check(obj)
{
	var check=new Ajax();
	check.getInfo("do.php","get","app","act=stamps&ajax=1&user_name="+obj,function(c){if(c){zkk=c;getdollar();}else{Dialog.alert('<?php echo $er_langpackage->er_Dos_notex;?>');}});
}

function getsumdollar()
{
	var zhekou=0;
	var who=document.getElementsByName("touser");
	if(who[0].checked==true)
	{
		if(document.getElementById("zkk").value=='base')
		{
			zhekou=0;
		}
		else
		{
			zhekou=document.getElementById("zkk").value;
		}
	}
	else
	{
		zhekou=zkk;
	}

	var sumdollar=new Number(document.getElementById("dollar").innerHTML);
	switch(zhekou)
	{
	   //case '1':
		// sumdollar=sumdollar*95/100;
		// break
	   case '2':
		 sumdollar=2*sumdollar;
		 break
	   case '3':
		 sumdollar=2*sumdollar;
		 break
	   default:
		 sumdollar=2*sumdollar;
	}
	document.getElementById("dollar").innerHTML=sumdollar.toFixed(2);
}

function getdollar()
{
	var obj=document.getElementById("sxzibi");
	if(obj.value=='')
	{
		var dollar="";
		var zibi=document.getElementsByName("zibi");
		for(var i=0;i<zibi.length;i++)
		{
			if(zibi[i].checked==true)
			{
				dollar=zibi[i].value;
			}
		}
		document.getElementById("dollar").innerHTML=2*dollar;
		document.getElementById("sxzibi").value='';
	}
	else
	{
		document.getElementById("dollar").innerHTML=2*obj.value;
	}
	getsumdollar();
}
</script>
<body onload="parent.get_mess_count();">
<div class="tabs" style="border:1px solid #ce1221;text-align:left;padding-left:15px;padding-top:5px;">
    <?php echo $info;?>
</div>
<div class="tabs">
    <ul class="menu">
        <li class="active"><a href="modules.php?app=user_stamps" hidefocus="true"><?php echo $s_langpackage->s_change;?></a></li>
        <li><a href="modules.php?app=user_help" hidefocus="true"><?php echo $er_langpackage->er_help;?></a></li>
        <li><a href="modules.php?app=stamps_help" hidefocus="true"><?php echo $s_langpackage->s_guize;?></a></li>
    </ul>
</div>
<div class="feedcontainer">
	<ul id="sec_Content">
	<form id="stamps" name="stamps" method="post" action="do.php">
	<input name="act" type="hidden" value="stamps" />
	<li style="height:auto;padding: 19px 25px 19px 25px;">
		<?php echo $s_langpackage->s_guize2;?>
	</li>
	<li style="height:auto;padding: 19px 25px 19px 25px;border-bottom:0px;">
		<table width="80%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">

			<tr>
				<td style="text-align:right;"><?php echo $s_langpackage->s_changenum;?>：</td>
				<td style="text-align:left;">
					<table width="270" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">
					  <tr>
						<td height="30"><input name="zibi" type="radio" value="20" onclick="getdollar()" />20&nbsp;<img src="/skin/<?php echo $skinUrl;?>/images/stamps.gif" style="vertical-align: middle;" /><!--<?php echo $er_langpackage->er_currency;?>--></td>
						<td><input name="zibi" type="radio" value="50" onclick="getdollar()" />50&nbsp;<img src="/skin/<?php echo $skinUrl;?>/images/stamps.gif" style="vertical-align: middle;" /></td>
						<td><input name="zibi" type="radio" value="100" onclick="getdollar()" />100&nbsp;<img src="/skin/<?php echo $skinUrl;?>/images/stamps.gif" style="vertical-align: middle;" /></td>
					  </tr>
					  <tr>
						<td height="30"><input name="zibi" type="radio" value="200" onclick="getdollar()" checked="checked" />200&nbsp;<img src="/skin/<?php echo $skinUrl;?>/images/stamps.gif" style="vertical-align: middle;" /></td>
						<td><input name="zibi" type="radio" value="500" onclick="getdollar()" />500&nbsp;<img src="/skin/<?php echo $skinUrl;?>/images/stamps.gif" style="vertical-align: middle;" /></td>
						<td><input name="zibi" type="radio" value="1000" onclick="getdollar()" />1000&nbsp;<img src="/skin/<?php echo $skinUrl;?>/images/stamps.gif" style="vertical-align: middle;" /></td>
					  </tr>
					</table>
				</td>
			</tr>
			<tr>
				<td style="text-align:right;height:50px;"><?php echo $er_langpackage->er_Other;?>：</td>
				<td style="text-align:left;">
					<label><input type="text" name="sxzibi" id="sxzibi" style="width:80px;height:25px;" onkeyup="value=value.replace(/[^\d]/g,'');getdollar();" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"  onkeydown="getdollar()" /></label>&nbsp;<font  style="font-weight:bold;"><?php echo $s_langpackage->s_stamps;?>&nbsp;&nbsp;<?php echo $er_langpackage->er_need;?>(</font><span style="color:red;" id="dollar"><?php echo $sumoney;?></span><font  style="font-weight:bold;">)<?php echo $er_langpackage->er_currency;?></font>
				</td>
			</tr>

			<tr>
				<td style="text-align:right;height:50px;">&nbsp;</td>
				<td style="text-align:left;">
					<input type="submit" name="button" id="button" style="background-image:url(/skin/<?php echo $skinUrl;?>/images/xin/an01.jpg);width:140px;height:29px;border:0px;font-weight:bold;color:#FFF;cursor:pointer;" value="<?php echo $s_langpackage->s_fastchange;?>" />
				</td>
			</tr>
		</table>
	</li>
</form>
</ul>
</div>
</body><?php } ?>